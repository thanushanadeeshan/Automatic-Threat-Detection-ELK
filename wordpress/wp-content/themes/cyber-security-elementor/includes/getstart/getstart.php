<?php

function get_page_id_by_title($cyber_security_elementor_pagename){
  $cyber_security_elementor_args = array(
 'post_type' => 'page',
 'posts_per_page' => 1,
 'title' => $cyber_security_elementor_pagename
  );
  $cyber_security_elementor_query = new WP_Query( $cyber_security_elementor_args );    $cyber_security_elementor_page_id = '1';
 if (isset($cyber_security_elementor_query->post->ID)) {
      $cyber_security_elementor_page_id = $cyber_security_elementor_query->post->ID;
  } return $cyber_security_elementor_page_id;
}
//about theme info
add_action( 'admin_menu', 'cyber_security_elementor_gettingstarted' );
function cyber_security_elementor_gettingstarted() {
	add_theme_page( esc_html__('Cyber Security Elementor', 'cyber-security-elementor'), esc_html__('Cyber Security Elementor', 'cyber-security-elementor'), 'edit_theme_options', 'cyber_security_elementor_about', 'cyber_security_elementor_mostrar_guide');
}

// Add a Custom CSS file to WP Admin Area
function cyber_security_elementor_admin_theme_style() {
	wp_enqueue_style('cyber-security-elementor-custom-admin-style', esc_url(get_template_directory_uri()) . '/includes/getstart/getstart.css');
	wp_enqueue_script('cyber-security-elementor-tabs', esc_url(get_template_directory_uri()) . '/includes/getstart/js/tab.js');
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri().'/assets/css/fontawesome-all.css' );

	// Admin notice code START
	wp_register_script('cyber-security-elementor-notice', esc_url(get_template_directory_uri()) . '/includes/getstart/js/notice.js', array('jquery'), time(), true);
	wp_enqueue_script('cyber-security-elementor-notice');
	// Admin notice code END
}
add_action('admin_enqueue_scripts', 'cyber_security_elementor_admin_theme_style');

// Changelog
if ( ! defined( 'CYBER_SECURITY_ELEMENTOR_CHANGELOG_URL' ) ) {
    define( 'CYBER_SECURITY_ELEMENTOR_CHANGELOG_URL', get_template_directory() . '/readme.txt' );
}

function cyber_security_elementor_changelog_screen() {
	global $wp_filesystem;
	$cyber_security_elementor_changelog_file = apply_filters( 'cyber_security_elementor_changelog_file', CYBER_SECURITY_ELEMENTOR_CHANGELOG_URL );

	if ( $cyber_security_elementor_changelog_file && is_readable( $cyber_security_elementor_changelog_file ) ) {
		WP_Filesystem();
		$cyber_security_elementor_changelog = $wp_filesystem->get_contents( $cyber_security_elementor_changelog_file );
		$cyber_security_elementor_changelog_list = cyber_security_elementor_parse_changelog( $cyber_security_elementor_changelog );

		
		echo '<div id="cyber-security-elementor-changelog-container">';
		echo wp_kses_post( $cyber_security_elementor_changelog_list );
		echo '</div>';
		echo '<button id="cyber-security-elementor-load-more" class="button button-primary" style="margin-top:15px;">Load More</button>';
	}
}

function cyber_security_elementor_parse_changelog( $cyber_security_elementor_content ) {
	$cyber_security_elementor_content = explode ( '== ', $cyber_security_elementor_content );
	$cyber_security_elementor_changelog_isolated = '';

	foreach ( $cyber_security_elementor_content as $key => $cyber_security_elementor_value ) {
		if ( strpos( $cyber_security_elementor_value, 'Changelog ==' ) === 0 ) {
	    	$cyber_security_elementor_changelog_isolated = str_replace( 'Changelog ==', '', $cyber_security_elementor_value );
	    }
	}

	$cyber_security_elementor_changelog_array = explode( '= ', $cyber_security_elementor_changelog_isolated );
	unset( $cyber_security_elementor_changelog_array[0] );

	$cyber_security_elementor_changelog = '<div class="changelog">';
	foreach ( $cyber_security_elementor_changelog_array as $cyber_security_elementor_value ) {
		$cyber_security_elementor_value = preg_replace( '/\n+/', '</span><span>', $cyber_security_elementor_value );
		$cyber_security_elementor_value = '<div class="block-changelog"><span class="heading">= ' . $cyber_security_elementor_value . '</span></div>';
		$cyber_security_elementor_changelog .= str_replace( '<span></span>', '', $cyber_security_elementor_value );
	}
	$cyber_security_elementor_changelog .= '</div>';

	return wp_kses_post( $cyber_security_elementor_changelog );
}

//guidline for about theme
function cyber_security_elementor_mostrar_guide() { 
	//custom function about theme customizer
	$cyber_security_elementor_return = add_query_arg( array()) ;
	$cyber_security_elementor_theme = wp_get_theme( 'cyber-security-elementor' );
	?>
<div class="container-getstarted">
		<div class="inner-side-content1">
			<div class="tab-outer-box">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/includes/getstart/images/sticky-header-logo.png" />
			</div>
		    <div class="coupon-container-box-left">
			    <div class="iner-sidebar-pro-btn">
				    <span class="premium-btn"><a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Premium Theme', 'cyber-security-elementor'); ?></a>
				    </span>
			    </div>
		    </div>
        </div>					
   <div class="top-head">
	    <div class="top-title">
		     <h2><?php esc_html_e( 'Cyber Security Elementor', 'cyber-security-elementor' ); ?></h2>
		     <h4><?php esc_html_e( 'Welcome to WP Elemento Theme!', 'cyber-security-elementor' ); ?></h4>
		     <p><?php esc_html_e( 'Click on the quick start button to import the demo.', 'cyber-security-elementor' ); ?></p>
			    <div class="iner-sidebar-pro-btn">
					<?php if(!class_exists('WPElemento_Importer_ThemeWhizzie')){
						$cyber_security_elementor_plugin_ins = Cyber_Security_Elementor_Plugin_Activation_WPElemento_Importer::get_instance();
						$cyber_security_elementor_actions = $cyber_security_elementor_plugin_ins->cyber_security_elementor_recommended_actions;
					?>
					<div class="cyber-security-elementor-recommended-plugins ">
						<div class="cyber-security-elementor-action-list">
							<?php if ($cyber_security_elementor_actions): foreach ($cyber_security_elementor_actions as $cyber_security_elementor_key => $cyber_security_elementor_actionValue): ?>
									<div class="cyber-security-elementor-action" id="<?php echo esc_attr($cyber_security_elementor_actionValue['id']);?>">
										<div class="action-inner plugin-activation-redirect">
											<?php echo wp_kses_post($cyber_security_elementor_actionValue['link']); ?>
										</div>
									</div>
								<?php endforeach;
							endif; ?>
						</div>
					</div>
				   <?php }else{ ?>
					<span class="quick-btn">
				    <?php if (isset($_GET['imported']) && $_GET['imported'] == 'true'): ?>
                        <a href="<?php echo esc_url( site_url() ); ?>" target="_blank"><?php esc_html_e('Visit Site', 'cyber-security-elementor'); ?></a>
						<?php
						$cyber_security_elementor_page_id = get_page_id_by_title('Home');
						?>
						<a href="<?php echo esc_url( admin_url('post.php?post=' . $cyber_security_elementor_page_id . '&action=elementor') ); ?>" 
							target="_blank" class="elementor-edit-btn"><?php esc_html_e('Edit With Elementor', 'cyber-security-elementor'); ?>
						</a>
                    <?php else: ?>
                        <a href="<?php echo esc_url( admin_url('admin.php?page=wpelementoimporter-wizard') ); ?>"><?php esc_html_e('Quick Start', 'cyber-security-elementor'); ?></a>
                    <?php endif; ?>
					<?php } ?>
				   </span>
				    <span class="premium-btn"><a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Premium', 'cyber-security-elementor'); ?></a>
				    </span>
				    <span class="demo-btn"><a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'cyber-security-elementor'); ?></a>
				    </span>
				    <span class="doc-btn"><a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e('Theme Bundle at $79', 'cyber-security-elementor'); ?></a>
				    </span>
			    </div>
            </div>			
		<div class="inner-side-content">
			<div class="tab-outer-box">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" />
			</div>
			<div class="top-right">
			  <span class="version"><?php esc_html_e( 'Version', 'cyber-security-elementor' ); ?>: <?php echo esc_html($cyber_security_elementor_theme['Version']);?></span>
		    </div>
		</div>
    </div>
    <div class="inner-cont">
	    <div class="tab-outer-box1">
		   <div class="tab-inner-box">
			   <div class= "bundle-box">
				    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/includes/getstart/images/bundle.png"/>
				    <h1><?php esc_html_e('ELEMENTOR WORDPRESS THEME BUNDLE', 'cyber-security-elementor'); ?></h1>
			     <div>
				    <p class="product-price"><?php esc_html_e('Price:', 'cyber-security-elementor'); ?>
                        <span class="regular-price"><?php esc_html_e('$1,999.00', 'cyber-security-elementor'); ?></span>
                        <span class="sale-price"><?php esc_html_e('$79.00', 'cyber-security-elementor'); ?></span>
                    </p>
					<p><?php esc_html_e('The Elementor WordPress Theme Bundle offers a stunning collection of 76+ Premium Elementor Themes', 'cyber-security-elementor'); ?></p>
                 </div>
				</div> 
			    <div class="offer-box"> 
				    <div class="offer1-box">
                       <span class="off-text1"><a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e('Buy Bundle at 20% Discount', 'cyber-security-elementor'); ?></a></span>
				    </div> 
		        </div>
			</div>	
		</div>	
		<div class="tab-outer-box2">
			<div class="tab-outer-box-2-1">
			  <h3><?php esc_html_e( 'Customizer Setting', 'cyber-security-elementor' ); ?></h3>
			  <div class="lite-theme-inner">
				<div>
					<h3><?php esc_html_e('Theme Customizer', 'cyber-security-elementor'); ?></h3>
					<p><?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'cyber-security-elementor'); ?></p>
					<div class="info-link">
					   <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Open customizer', 'cyber-security-elementor'); ?></a>
					</div>
				</div>
				<div>
					<h3><?php esc_html_e('Help Docs', 'cyber-security-elementor'); ?></h3>
					<p><?php esc_html_e('The complete procedure to configure and manage a WordPress Website from the beginning is shown in this documentation .', 'cyber-security-elementor'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_FREE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'cyber-security-elementor'); ?></a>
					</div>
				</div>
				<div>
					<h3><?php esc_html_e('Need Support?', 'cyber-security-elementor'); ?></h3>
					<p><?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'cyber-security-elementor'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'cyber-security-elementor'); ?></a>
					</div>
				</div>
				<div>
					<h3><?php esc_html_e('Reviews & Testimonials', 'cyber-security-elementor'); ?></h3>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'cyber-security-elementor'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( CYBER_SECURITY_ELEMENTOR_REVIEW ); ?>" target="_blank"><?php esc_html_e('Review', 'cyber-security-elementor'); ?></a>
					</div>
				</div>
            </div>	
		</div>
			<div class="tab-outer-box-2-2">
			  <h3><?php esc_html_e( 'Link to customizer', 'cyber-security-elementor' ); ?></h3>
				<div class="first-row">
					<div class="row-box">
						<div class="row-box1">
							<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your Website logo','cyber-security-elementor'); ?></a>
						</div>
						<div class="row-box2">
							<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Edit Your Menus','cyber-security-elementor'); ?></a>
						</div>
					</div>
							
					<div class="row-box">
						<div class="row-box1">
							<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=header_image') ); ?>" target="_blank"><?php esc_html_e('Add Header Image','cyber-security-elementor'); ?></a>
						</div>
						<div class="row-box2">
							<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Add Footer Widget','cyber-security-elementor'); ?></a>
						</div>
					</div>
				</div>
            </div>	
			<div class="tab-outer-box-2-3">
				<h3><?php esc_html_e( 'Change log', 'cyber-security-elementor' ); ?></h3>	
		     <?php cyber_security_elementor_changelog_screen(); ?>
          </div>	
        </div>
    </div>
</div>	
<?php } ?>