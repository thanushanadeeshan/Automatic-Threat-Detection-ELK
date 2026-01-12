# ==========================================================
# ⚔️ ADVANCED ATTACK SIMULATOR (Red Team Tool)
# targeted specifically for your ML Engine features
# ==========================================================

import requests
import time
import random
import threading
import sys

# 🎯 CONFIGURATION
TARGET_URL = "http://localhost/threat_detection_db"  # Ensure Apache/XAMPP is running
THREAD_COUNT = 5                 # Number of concurrent threads for brute force

# 🎨 COLORS
class Colors:
    RED = '\033[91m'
    GREEN = '\033[92m'
    YELLOW = '\033[93m'
    BLUE = '\033[94m'
    RESET = '\033[0m'

# 🛡️ HEADERS POOL
USER_AGENTS = [
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)",
    "Googlebot/2.1 (+http://www.google.com/bot.html)",
    "Python-urllib/3.8",
    "SQLMap/1.5.2"
]

def fire(path, delay=0):
    """Sends a single request"""
    url = f"{TARGET_URL}{path}"
    ua = random.choice(USER_AGENTS)
    try:
        # We allow redirects=False to capture 301/302 codes accurately
        response = requests.get(url, headers={"User-Agent": ua}, timeout=4, allow_redirects=True)
        
        status = response.status_code
        if status == 200:
            print(f"{Colors.GREEN}[{status}] ✔️  Success: {path}{Colors.RESET}")
        elif status == 404:
            print(f"{Colors.YELLOW}[{status}] ⚠️  Not Found: {path}{Colors.RESET}")
        elif status in [403, 401]:
            print(f"{Colors.RED}[{status}] 🚫 Forbidden: {path}{Colors.RESET}")
        else:
            print(f"[{status}] 🔫 Fired at: {path}")
            
    except requests.exceptions.ConnectionError:
        print(f"{Colors.RED}❌ Connection Failed! Server down?{Colors.RESET}")
    
    if delay > 0:
        time.sleep(delay)

# ==========================================================
# 🩺 1. NORMAL TRAFFIC (The Baseline)
# ==========================================================
def generate_normal_traffic():
    """Generates safe, 200 OK traffic to train the 'Normal' ML baseline"""
    print(f"\n{Colors.BLUE}[🕊️] GENERATING NORMAL USER TRAFFIC...{Colors.RESET}")
    print("------------------------------------------------")
    safe_paths = ["/", "/index.html", "/about", "/contact", "/products", "/style.css", "/logo.png", "/js/app.js"]
    
    for _ in range(20):
        path = random.choice(safe_paths)
        fire(path, delay=random.uniform(0.5, 2.0)) # Random human-like delay

# ==========================================================
# 🔨 2. BRUTE FORCE (Triggers 'Request Count' & 'Burstiness')
# ==========================================================
def attack_brute_force():
    """High volume requests to trigger Isolation Forest & Request Count > 30"""
    print(f"\n{Colors.RED}[🔥] LAUNCHING MULTI-THREADED BRUTE FORCE...{Colors.RESET}")
    print("------------------------------------------------")
    
    paths = ["/login", "/signin", "/wp-login.php", "/api/auth"]
    
    def worker():
        for _ in range(15): # 15 reqs per thread * 5 threads = 75 total (Trigger > 30)
            path = random.choice(paths)
            fire(path) # No delay = Burst!

    threads = []
    for _ in range(THREAD_COUNT):
        t = threading.Thread(target=worker)
        threads.append(t)
        t.start()
    
    for t in threads:
        t.join()
        
    print(">> Brute Force Burst Complete.")

# ==========================================================
# 🕵️ 3. PRIVILEGE ESCALATION (Triggers 'Admin Attempts')
# ==========================================================
def attack_privilege_escalation():
    """Targeted admin probes to trigger 'Admin Access > 2'"""
    print(f"\n{Colors.YELLOW}[🕵️] PROBING FOR ADMIN ACCESS...{Colors.RESET}")
    print("------------------------------------------------")
    
    # These keywords specifically match your ML regex: r"admin|login|dashboard"
    admin_paths = [
        "/admin", "/administrator", "/wp-admin", "/dashboard", 
        "/cpanel", "/root", "/login.php?user=admin", "/admin/users"
    ]
    
    for path in admin_paths:
        fire(path, delay=0.5)

    print(">> Privilege Probe Complete.")

# ==========================================================
# 💾 4. MASS DOWNLOAD (Triggers 'Download Activity')
# ==========================================================
def attack_mass_download():
    """Requests files to trigger 'Download Activity > 5'"""
    print(f"\n{Colors.BLUE}[💾] ATTEMPTING MASS DATA EXFILTRATION...{Colors.RESET}")
    print("------------------------------------------------")
    
    # Extensions matching your regex: r"\.zip|\.exe|\.pdf|\.doc|\.rar"
    files = [
        "/backup.zip", "/database.sql", "/users.csv", 
        "/invoice.pdf", "/installer.exe", "/source_code.rar", "/secret.doc"
    ]
    
    for _ in range(2): # Loop twice to ensure we exceed count of 5
        for path in files:
            fire(path, delay=0.2)

    print(">> Download Attack Complete.")

# ==========================================================
# 🚫 5. SENSITIVE FILES (Triggers 'Unauthorized Access')
# ==========================================================
def attack_sensitive_files():
    """Accessing config files to trigger 'Unauthorized URL > 3'"""
    print(f"\n{Colors.RED}[🚫] HUNTING FOR SECRETS (.env/config)...{Colors.RESET}")
    print("------------------------------------------------")
    
    # Regex matches: r"/etc|/config|/\.env|/backup"
    files = [
        "/.env", "/config.php", "/etc/passwd", "/wp-config.php", 
        "/id_rsa", "/aws_keys.txt", "/backup/db.sql"
    ]
    
    for path in files:
        fire(path, delay=0.8)

    print(">> Secret Scan Complete.")

# ==========================================================
# 🚀 MAIN MENU
# ==========================================================
if __name__ == "__main__":
    print(f"""
{Colors.RED}    ___  _______  __________  ________ __
   /   |/_  __/ |/ /   / __ \/ ____/ //_/
  / /| | / /  |   /   / / / / /   / ,<   
 / ___ |/ /  /   |   / /_/ / /___/ /| |  
/_/  |_/_/  /_/|_|  /_____/\____/_/ |_|  
    SIMULATOR v2.0 | Target: {TARGET_URL} {Colors.RESET}
    """)
    
    print("1. 🕊️  Simulate Normal Traffic (Training Data)")
    print("2. 🔥  Brute Force Attack (High Noise)")
    print("3. 🕵️  Admin Privilege Escalation")
    print("4. 💾  Mass Data Exfiltration (Downloads)")
    print("5. 🚫  Sensitive File Theft")
    print(f"6. ☠️  {Colors.RED}RUN FULL KILL CHAIN (All of the above){Colors.RESET}")
    
    choice = input("\nSelect Mode (1-6): ")

    if choice == '1':
        generate_normal_traffic()
    elif choice == '2':
        attack_brute_force()
    elif choice == '3':
        attack_privilege_escalation()
    elif choice == '4':
        attack_mass_download()
    elif choice == '5':
        attack_sensitive_files()
    elif choice == '6':
        generate_normal_traffic()
        time.sleep(1)
        attack_brute_force()
        time.sleep(1)
        attack_mass_download()
        time.sleep(1)
        attack_privilege_escalation()
        time.sleep(1)
        attack_sensitive_files()
        print(f"\n{Colors.GREEN}>> KILL CHAIN COMPLETE. CHECK YOUR DASHBOARD! <<{Colors.RESET}")
    else:
        print("Invalid choice.")