

import matplotlib
# CRITICAL FIX: Use 'Agg' backend to prevent Windows/Tkinter crashes
matplotlib.use("Agg") 

import warnings
import pandas as pd
import numpy as np
import urllib3
import time
import os
from datetime import datetime
from elasticsearch import Elasticsearch
from sklearn.ensemble import IsolationForest
from sklearn.neighbors import LocalOutlierFactor
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score
import matplotlib.pyplot as plt

# -------------------------------
# 1. CONFIGURATION
# -------------------------------
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)
warnings.filterwarnings("ignore")

ES_HOST = "https://localhost:9200"
ES_USER = "elastic"
ES_PASS = "vQ8QSdp3jJtUw9mQcVlM"  # ⚠️ Replace with your password
SOURCE_INDEX = "filebeat-*"
TARGET_INDEX = "ml-threats-report"

# -------------------------------
# 2. CONNECT TO ELASTICSEARCH
# -------------------------------
print(f"[{datetime.now().strftime('%H:%M:%S')}] Connecting to Elasticsearch...")

es = Elasticsearch(
    ES_HOST,
    basic_auth=(ES_USER, ES_PASS),
    verify_certs=False,
    ssl_show_warn=False
)

if not es.ping():
    print("❌ Connection failed! Is Elasticsearch running?")
    exit()

print("✅ Connected successfully!\n")

# ==========================================================
# 3. CORE FUNCTIONS
# ==========================================================

def fetch_logs(minutes=60):
    """Fetch Apache logs from the last N minutes"""
    query = {
        "query": {
            "bool": {
                "must": [
                    {"range": {"@timestamp": {"gte": f"now-{minutes}m", "lt": "now"}}},
                    {"match": {"event.module": "apache"}}
                ]
            }
        },
        "size": 10000
    }

    try:
        response = es.search(index=SOURCE_INDEX, body=query)
        hits = response["hits"]["hits"]
    except Exception as e:
        print(f"⚠️ Log fetch error: {e}")
        return pd.DataFrame()

    data = []
    for hit in hits:
        src = hit["_source"]
        data.append({
            "timestamp": src.get("@timestamp"),
            "source_ip": src.get("source", {}).get("ip", "unknown"),
            "status_code": src.get("http", {}).get("response", {}).get("status_code", 200),
            "request": src.get("url", {}).get("path", "")
        })

    return pd.DataFrame(data)

def preprocess_data(df):
    """Convert raw logs into ML features"""
    df["timestamp"] = pd.to_datetime(df["timestamp"], utc=True)
    df.set_index("timestamp", inplace=True)

    # UBA Feature Extraction
    df["is_download"] = df["request"].str.contains(r"\.zip|\.exe|\.pdf|\.doc|\.rar", na=False).astype(int)
    df["is_admin"] = df["request"].str.contains(r"admin|login|dashboard", case=False, na=False).astype(int)
    df["is_unauth"] = df["request"].str.contains(r"/etc|/config|/\.env|/backup", na=False).astype(int)

    # Aggregation per IP per Minute
    features = df.groupby(["source_ip"]).resample("1min").agg({
        "status_code": [
            "count",
            lambda x: (x >= 400).sum(),
            lambda x: (x == 401).sum(),
            lambda x: (x == 403).sum(),
            lambda x: (x == 404).sum()
        ],
        "is_download": "sum",
        "is_admin": "sum",
        "is_unauth": "sum"
    }).fillna(0)

    features.columns = [
        "request_count", "error_count", "unauthorized_401", "forbidden_403", 
        "not_found_404", "download_activity", "admin_access_attempts", "unauthorized_url_attempts"
    ]
    features.reset_index(inplace=True)

    # Derived Features
    features["error_ratio"] = features["error_count"] / (features["request_count"] + 1)
    features["burstiness"] = (
        features.groupby("source_ip")["request_count"]
        .rolling(3).mean()
        .reset_index(level=0, drop=True)
        .fillna(0)
    )

    return features

def train_and_detect(features):
    """Train ML Models (Isolation Forest + LOF)"""
    X = features[[
        "request_count", "error_count", "unauthorized_401", "forbidden_403", "not_found_404",
        "error_ratio", "burstiness", "download_activity", "admin_access_attempts", "unauthorized_url_attempts"
    ]]

    # High Sensitivity Settings (Contamination=0.2 catches top 20% anomalies)
    iso = IsolationForest(n_estimators=200, contamination=0.2, random_state=42, n_jobs=1)
    iso.fit(X)
    features["iso_score"] = iso.predict(X)
    features["threat_score"] = -iso.decision_function(X)

    lof = LocalOutlierFactor(n_neighbors=20, contamination=0.2, n_jobs=1)
    features["lof_score"] = lof.fit_predict(X)

    # Ensemble: Flag if EITHER model detects a threat
    features["anomaly_score"] = np.where(
        (features["iso_score"] == -1) | (features["lof_score"] == -1), -1, 1
    )

    return features

def classify_threat(row):
    """Logic to name the attack based on behavior"""
    if row["anomaly_score"] == 1:
        return "Normal"
    
    # 1. PRIORITY: Check for Brute Force (High Volume) first
    # This prevents "Admin Access" from hiding a Brute Force attack
    if row["request_count"] > 30:
        return "Brute Force Attack"

    # 2. SECONDARY: Check for Targeted Probing (Low & Slow)
    if row["admin_access_attempts"] > 2:
        return "Privilege Escalation Attempt"
    if row["download_activity"] > 5:
        return "Suspicious Mass Download"
    if row["unauthorized_url_attempts"] > 3:
        return "Unauthorized Resource Access"
        
    return "Suspicious Behavior"

# ==========================================================
# 4. IPS MODULE (ACTIVE DEFENSE)
# ==========================================================

def block_ip(ip_address, threat_score):
    """Simulates a Firewall Block"""
    if threat_score > 0.60: # Only block HIGH severity
        print(f"🚫 [IPS] BLOCKING IP: {ip_address} (Score: {threat_score:.2f})")
        
        # Log to file (Mock Firewall)
        with open("blocked_ips.txt", "a") as f:
            f.write(f"{datetime.now()} - Blocked {ip_address} - Score: {threat_score}\n")
        return True
    return False

def upload_threats(features):
    """Process threats: Block IP -> Upload to ES -> Log to Console"""
    threats = features[features["anomaly_score"] == -1].copy()

    if threats.empty:
        print(f"[{datetime.now().strftime('%H:%M:%S')}] System Clean.")
        return

    threats["threat_type"] = threats.apply(classify_threat, axis=1)

    print("\n" + "="*60)
    print(f"🔥 DETECTED {len(threats)} THREATS!")
    print(threats[['timestamp', 'source_ip', 'threat_type', 'request_count']].head())
    print("="*60)

    for _, row in threats.iterrows():
        # 1. IPS Action
        is_blocked = block_ip(row["source_ip"], row["threat_score"])
        
        # 2. Index to Elasticsearch
        doc = {
            "@timestamp": row["timestamp"].isoformat(),
            "attacker_ip": row["source_ip"],
            "threat_type": row["threat_type"],
            "threat_score": float(row["threat_score"]),
            "severity": "High" if row["threat_score"] > 0.6 else "Medium",
            "request_count": int(row["request_count"]),
            "error_count": int(row["error_count"]),
            "action_taken": "Blocked" if is_blocked else "Monitored"
        }
        es.index(index=TARGET_INDEX, document=doc)

    print(f"🚀 Uploaded {len(threats)} alerts to Elasticsearch")

# ==========================================================
# 5. VISUALIZATION & METRICS
# ==========================================================

def visualize_results(features):
    """Save a scatter plot image (Headless)"""
    plt.clf() 
    normal = features[features["anomaly_score"] == 1]
    threats = features[features["anomaly_score"] == -1]

    # Plot Normal Traffic (Blue)
    plt.scatter(normal["request_count"], normal["error_count"], alpha=0.4, label="Normal", c='blue')
    
    # Plot Threats (Red)
    if not threats.empty:
        plt.scatter(threats["request_count"], threats["error_count"], marker="x", s=100, label="Threat", c='red')

    plt.xlabel("Request Count")
    plt.ylabel("Error Count")
    plt.title(f"Live Threat Detection | {datetime.now().strftime('%H:%M:%S')}")
    plt.legend()
    plt.grid(True, linestyle='--', alpha=0.6)
    
    # Save file silently to avoid crash
    filename = "live_threat_graph.png"
    plt.savefig(filename)
    print(f"📊 Graph updated: {filename}")

def evaluate_model(features):
    """Calculate and print Accuracy Metrics"""
    # Ground Truth Rule: Requests > 30 OR Admin > 2 is a "Real" Threat
    features["true_label"] = np.where(
        (features["request_count"] > 30) |
        (features["admin_access_attempts"] > 2) |
        (features["unauthorized_url_attempts"] > 3), 
        1, 0
    )
    features["predicted_label"] = np.where(features["anomaly_score"] == -1, 1, 0)

    if features["true_label"].sum() > 0:
        acc = accuracy_score(features["true_label"], features["predicted_label"])
        prec = precision_score(features["true_label"], features["predicted_label"], zero_division=0)
        rec = recall_score(features["true_label"], features["predicted_label"], zero_division=0)
        f1 = f1_score(features["true_label"], features["predicted_label"], zero_division=0)

        print("\n📊 MODEL PERFORMANCE REPORT")
        print("-" * 30)
        print(f"   Accuracy : {acc:.2%}")
        print(f"   Precision: {prec:.2%}")
        print(f"   Recall   : {rec:.2%}")
        print(f"   F1-Score : {f1:.2%}")
        print("-" * 30)

# ==========================================================
# 6. MAIN LOOP
# ==========================================================

if __name__ == "__main__":
    print("🛡️ STARTING ADVANCED THREAT DETECTION ENGINE...")
    print("   [Press Ctrl+C to Stop]")
    
    while True:
        try:
            logs = fetch_logs(60)
            if not logs.empty:
                features = preprocess_data(logs)
                features = train_and_detect(features)
                upload_threats(features)
                visualize_results(features)
                evaluate_model(features)
            else:
                print(f"[{datetime.now().strftime('%H:%M:%S')}] No logs found. Waiting for traffic...")

        except Exception as e:
            print(f"❌ CRITICAL ERROR: {e}")

        # Refresh every 10 seconds
        time.sleep(10)