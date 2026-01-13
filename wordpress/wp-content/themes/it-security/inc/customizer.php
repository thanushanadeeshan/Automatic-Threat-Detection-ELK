<?php
/**
 * IT Security Theme Customizer
 *
 * @package IT Security
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function it_security_customize_register( $wp_customize ) {

	function it_security_sanitize_dropdown_pages( $page_id, $setting ) {
  		$page_id = absint( $page_id );
  		return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	wp_enqueue_style('it-security-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'/css/customize-controls.css');

	// Enable / Disable Logo
	$wp_customize->add_setting('it_security_logo_enable',array(
		'default' => true,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control( 'it_security_logo_enable', array(
		'settings' => 'it_security_logo_enable',
		'section'   => 'title_tagline',
		'label'     => __('Enable Logo','it-security'),
		'type'      => 'checkbox'
	));

	//Logo
    $wp_customize->add_setting('it_security_logo_width', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'it_security_sanitize_integer'
    ));
    $wp_customize->add_control(new IT_Security_Slider_Custom_Control($wp_customize, 'it_security_logo_width', array(
    	'label'          => __( 'Logo Width', 'it-security'),
        'section' => 'title_tagline',
        'settings' => 'it_security_logo_width',
        'input_attrs' => array(
            'step' => 1,
            'min' => 0,
            'max' => 150,
        ),
    )));

	// color site title
	$wp_customize->add_setting('it_security_sitetitle_color',array(
		'default' => '',
		'sanitize_callback' => 'it_security_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'it_security_sitetitle_color', array(
	   'settings' => 'it_security_sitetitle_color',
	   'section'   => 'title_tagline',
	   'label' => __('Site Title Color', 'it-security'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('it_security_title_enable',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control( 'it_security_title_enable', array(
	   'settings' => 'it_security_title_enable',
	   'section'   => 'title_tagline',
	   'label'     => __('Enable Site Title','it-security'),
	   'type'      => 'checkbox'
	));

	// color site tagline
	$wp_customize->add_setting('it_security_sitetagline_color',array(
		'default' => '',
		'sanitize_callback' => 'it_security_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_sitetagline_color', array(
	   'settings' => 'it_security_sitetagline_color',
	   'section'   => 'title_tagline',
	   'label' => __('Site Tagline Color', 'it-security'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('it_security_tagline_enable',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control( 'it_security_tagline_enable', array(
	   'settings' => 'it_security_tagline_enable',
	   'section'   => 'title_tagline',
	   'label'     => __('Enable Site Tagline','it-security'),
	   'type'      => 'checkbox'
	));

	// woocommerce section
	$wp_customize->add_section('it_security_woocommerce_page_settings', array(
		'title'    => __('WooCommerce Page Settings', 'it-security'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting('it_security_shop_page_sidebar',array(
		'default' => false,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
	 ));
	 $wp_customize->add_control('it_security_shop_page_sidebar',array(
		'type' => 'checkbox',
		'label' => __(' Check To Enable Shop page sidebar','it-security'),
		'section' => 'it_security_woocommerce_page_settings',
	 ));

    // shop page sidebar alignment
    $wp_customize->add_setting('it_security_shop_page_sidebar_position', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'it_security_sanitize_choices',
	));
	$wp_customize->add_control('it_security_shop_page_sidebar_position',array(
		'type'           => 'radio',
		'label'          => __('Shop Page Sidebar', 'it-security'),
		'section'        => 'it_security_woocommerce_page_settings',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'it-security'),
			'Right Sidebar' => __('Right Sidebar', 'it-security'),
		),
	));	 

	$wp_customize->add_setting('it_security_wooproducts_nav',array(
		'default' => 'Yes',
		'sanitize_callback'	=> 'it_security_sanitize_choices'
	 ));
	 $wp_customize->add_control('it_security_wooproducts_nav',array(
		'type' => 'select',
		'label' => __('Shop Page Products Navigation','it-security'),
		'choices' => array(
			 'Yes' => __('Yes','it-security'),
			 'No' => __('No','it-security'),
		 ),
		'section' => 'it_security_woocommerce_page_settings',
	 ));

	 $wp_customize->add_setting( 'it_security_single_page_sidebar',array(
		'default' => false,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
    ) );
    $wp_customize->add_control('it_security_single_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Check To Enable Single Product Page Sidebar','it-security'),
		'section' => 'it_security_woocommerce_page_settings'
    ));

	// single product page sidebar alignment
    $wp_customize->add_setting('it_security_single_product_page_layout', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'it_security_sanitize_choices',
	));
	$wp_customize->add_control('it_security_single_product_page_layout',array(
		'type'           => 'radio',
		'label'          => __('Single product Page Sidebar', 'it-security'),
		'section'        => 'it_security_woocommerce_page_settings',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'it-security'),
			'Right Sidebar' => __('Right Sidebar', 'it-security'),
		),
	));

	$wp_customize->add_setting('it_security_related_product_enable',array(
		'default' => true,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
	));
	$wp_customize->add_control('it_security_related_product_enable',array(
		'type' => 'checkbox',
		'label' => __('Check To Enable Related product','it-security'),
		'section' => 'it_security_woocommerce_page_settings',
	));

	$wp_customize->add_setting( 'it_security_woo_product_img_border_radius', array(
        'default'              => '0',
        'transport'            => 'refresh',
        'sanitize_callback'    => 'it_security_sanitize_integer'
    ) );
    $wp_customize->add_control(new IT_Security_Slider_Custom_Control( $wp_customize, 'it_security_woo_product_img_border_radius',array(
		'label'	=> esc_html__('Woo Product Img Border Radius','it-security'),
		'section'=> 'it_security_woocommerce_page_settings',
		'settings'=>'it_security_woo_product_img_border_radius',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 100,
        ),
	)));

	// Add a setting for number of products per row
    $wp_customize->add_setting('it_security_products_per_row', array(
	    'default'   => '4',
	    'transport' => 'refresh',
	    'sanitize_callback' => 'it_security_sanitize_integer'  
    ));

   	$wp_customize->add_control('it_security_products_per_row', array(
	   'label'    => __('Products Per Row', 'it-security'),
	   'section'  => 'it_security_woocommerce_page_settings',
	   'settings' => 'it_security_products_per_row',
	   'type'     => 'select',
	   'choices'  => array(
			'2' => '2',
			'3' => '3',
			'4' => '4',
	  ),
   	) );
   
   	// Add a setting for the number of products per page
	$wp_customize->add_setting('it_security_products_per_page', array(
		'default'   => '8',
		'transport' => 'refresh',
		'sanitize_callback' => 'it_security_sanitize_integer'
	));

	$wp_customize->add_control('it_security_products_per_page', array(
		'label'    => __('Products Per Page', 'it-security'),
		'section'  => 'it_security_woocommerce_page_settings',
		'settings' => 'it_security_products_per_page',
		'type'     => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'step' => 1,
		),
	));

	//Theme Options
	$wp_customize->add_panel( 'it_security_panel_area', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'title' => __( 'Theme Options Panel', 'it-security' ),
	) );

	//Site Layout Section
	$wp_customize->add_section('it_security_site_layoutsec',array(
		'title'	=> __('Manage Site Layout Section ','it-security'),
		'description' => __('<p class="sec-title">Manage Site Layout Section</p>','it-security'),
		'priority'	=> 1,
		'panel' => 'it_security_panel_area',
	));

	$wp_customize->add_setting('it_security_preloader',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control( 'it_security_preloader', array(
	   'section'   => 'it_security_site_layoutsec',
	   'label'	=> __('Check to Show preloader','it-security'),
	   'type'      => 'checkbox'
 	));	

	$wp_customize->add_setting('it_security_box_layout',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control( 'it_security_box_layout', array(
	   'section'   => 'it_security_site_layoutsec',
	   'label'	=> __('Check to Show Box Layout','it-security'),
	   'type'      => 'checkbox'
 	));

	$wp_customize->add_setting( 'it_security_site_layoutsec_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_site_layoutsec_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_site_layoutsec'
	));

	//Global Color
	$wp_customize->add_section('it_security_global_color', array(
		'title'    => __('Manage Global Color Section', 'it-security'),
		'panel'    => 'it_security_panel_area',
	));

	$wp_customize->add_setting('it_security_first_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'it_security_first_color', array(
		'label'    => __('Theme Color', 'it-security'),
		'section'  => 'it_security_global_color',
		'settings' => 'it_security_first_color',
	)));

	$wp_customize->add_setting('it_security_second_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'it_security_second_color', array(
		'label'    => __('Theme Color', 'it-security'),
		'section'  => 'it_security_global_color',
		'settings' => 'it_security_second_color',
	)));

	$wp_customize->add_setting( 'it_security_global_color_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_global_color_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_global_color'
	));

	// Header Section
	$wp_customize->add_section('it_security_topbar_section',array(
	    'title' => __('Manage Header Section','it-security'),
	    'description' => __('<p class="sec-title">Manage Header Section</p>', 'it-security'),
	    'priority'  => null,
	    'panel' => 'it_security_panel_area',
	));	

	$wp_customize->add_setting('it_security_topbar_text', array(
	    'default'           => '',
	    'sanitize_callback' => 'sanitize_text_field',
	    'capability'        => 'edit_theme_options',
	));
	$wp_customize->add_control('it_security_topbar_text', array(
	    'settings' => 'it_security_topbar_text',
	    'section'  => 'it_security_topbar_section',
	    'label'    => __('Add Topbar Text', 'it-security'),
	    'type'     => 'text',
	));

	$wp_customize->add_setting('it_security_header_user_link', array(
	    'default'           => '',
	    'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('it_security_header_user_link', array(
	    'label'    => __('Add Link', 'it-security'),
	    'section'  => 'it_security_topbar_section',
	    'type'     => 'url',
	));

	$wp_customize->add_setting('it_security_stickyheader',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control( 'it_security_stickyheader', array(
	   'section'   => 'it_security_topbar_section',
	   'label'	=> __('Check To Show Sticky Header','it-security'),
	   'type'      => 'checkbox'
 	));

    // Menu Text Transform
    $wp_customize->add_setting( 'it_security_menu_text_transform', array(
        'default'           => 'Uppercase',
		'transport' => 'refresh',
		'sanitize_callback' => 'it_security_sanitize_choices'
    ));

    $wp_customize->add_control( 'it_security_menu_text_transform', array(
        'label'    => __( 'Menu Text Transform', 'it-security' ),
        'section'  => 'it_security_topbar_section',
        'type'     => 'select',
        'choices'  => array(
			'None'       => __( 'None', 'it-security' ),
            'Capitalize' => __( 'Capitalize', 'it-security' ),
            'Uppercase'  => __( 'Uppercase', 'it-security' ),
            'Lowercase'  => __( 'Lowercase', 'it-security' ),
        ),
    ));

	$wp_customize->add_setting( 'it_security_topbar_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_topbar_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_topbar_section'
	));

	// Banner Section
	$wp_customize->add_section('it_security_banner_section',array(
	    'title' => __('Manage Banner Section','it-security'),
	    'priority'  => null,
	    'description'	=> __('<p class="sec-title">Manage Banner Section</p>','it-security'),
	    'panel' => 'it_security_panel_area',
	));	

	$wp_customize->add_setting('it_security_banner',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_banner', array(
	   'settings' => 'it_security_banner',
	   'section'   => 'it_security_banner_section',
	   'label'     => __('Check To Enable This Section','it-security'),
	   'type'      => 'checkbox'
	));

	// Page Dropdown
	$wp_customize->add_setting('it_security_banner_pageboxes', array(
	    'default'           => '0',
	    'capability'        => 'edit_theme_options',
	    'sanitize_callback' => 'it_security_sanitize_dropdown_pages',
	));
	$wp_customize->add_control('it_security_banner_pageboxes', array(
	    'type'     => 'dropdown-pages',
	    'label'    => __('Select Page to display Banner', 'it-security'),
	    'section'  => 'it_security_banner_section',
	));

	// Button Text
	$wp_customize->add_setting('it_security_button_text', array(
	    'default'           => 'Explore More',
	    'sanitize_callback' => 'sanitize_text_field',
	    'capability'        => 'edit_theme_options',
	));
	$wp_customize->add_control('it_security_button_text', array(
	    'settings' => 'it_security_button_text',
	    'section'  => 'it_security_banner_section',
	    'label'    => __('Add Banner Button Text', 'it-security'),
	    'type'     => 'text',
	));

	// Button Link
	$wp_customize->add_setting('it_security_button_link_banner', array(
	    'default'           => '',
	    'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('it_security_button_link_banner', array(
	    'label'    => __('Add Banner Button Link', 'it-security'),
	    'section'  => 'it_security_banner_section',
	    'type'     => 'url',
	));

	$wp_customize->add_setting( 'it_security_banner_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_banner_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_banner_section'
	));

	// Case Section
	$wp_customize->add_section('it_security_case_study_section', array(
	    'title'       => __('Manage Case Study Section', 'it-security'),
	    'description' => __('<p class="sec-title">Manage Case Section</p>', 'it-security'),
	    'priority'    => null,
	    'panel'       => 'it_security_panel_area',
	));

	$wp_customize->add_setting('it_security_show_case_section',array(
		'default' => false,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_show_case_section', array(
	   'settings' => 'it_security_show_case_section',
	   'section'   => 'it_security_case_study_section',
	   'label'     => __('Check To Enable This Section','it-security'),
	   'type'      => 'checkbox'
	));

	$wp_customize->add_setting('it_security_case_study_sec_title', array(
	    'default'           => '',
	    'sanitize_callback' => 'sanitize_text_field',
	    'capability'        => 'edit_theme_options',
	));
	$wp_customize->add_control('it_security_case_study_sec_title', array(
	    'settings' => 'it_security_case_study_sec_title',
	    'section'  => 'it_security_case_study_section',
	    'label'    => __('Add Section Title', 'it-security'),
	    'type'     => 'text',
	));

	$wp_customize->add_setting('it_security_case_study_sec_text', array(
	    'default'           => '',
	    'sanitize_callback' => 'sanitize_text_field',
	    'capability'        => 'edit_theme_options',
	));
	$wp_customize->add_control('it_security_case_study_sec_text', array(
	    'settings' => 'it_security_case_study_sec_text',
	    'section'  => 'it_security_case_study_section',
	    'label'    => __('Add Section Text', 'it-security'),
	    'type'     => 'text',
	));

	$it_security_categories = get_categories();
	$it_security_cat_post = array();
	$it_security_cat_post['0'] = 'Select';

	foreach ($it_security_categories as $it_security_category) {
	    $it_security_cat_post[$it_security_category->slug] = $it_security_category->name;
	}

	$wp_customize->add_setting('it_security_select_case_cat', array(
	    'default' => '0',
	    'sanitize_callback' => 'it_security_sanitize_choices',
	));
	$wp_customize->add_control('it_security_select_case_cat', array(
	    'type'    => 'select',
	    'choices' => $it_security_cat_post,
	    'label'   => __('Select Category to display Latest Post', 'it-security'),
	    'section' => 'it_security_case_study_section',
	));
	
	$wp_customize->add_setting( 'it_security_blog_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_blog_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_case_study_section'
	));

	//Blog post
	$wp_customize->add_section('it_security_blog_post_settings',array(
        'title' => __('Manage Post Section', 'it-security'),
        'priority' => null,
        'panel' => 'it_security_panel_area'
    ) );

	$wp_customize->add_setting('it_security_metafields_date', array(
	    'default' => true,
	    'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control('it_security_metafields_date', array(
	    'settings' => 'it_security_metafields_date', 
	    'section'   => 'it_security_blog_post_settings',
	    'label'     => __('Check to Enable Date', 'it-security'),
	    'type'      => 'checkbox',
	));

	$wp_customize->add_setting('it_security_metafields_comments', array(
		'default' => true,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));	
	$wp_customize->add_control('it_security_metafields_comments', array(
		'settings' => 'it_security_metafields_comments',
		'section'  => 'it_security_blog_post_settings',
		'label'    => __('Check to Enable Comments', 'it-security'),
		'type'     => 'checkbox',
	));

	$wp_customize->add_setting('it_security_metafields_author', array(
		'default' => true,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control('it_security_metafields_author', array(
		'settings' => 'it_security_metafields_author',
		'section'  => 'it_security_blog_post_settings',
		'label'    => __('Check to Enable Author', 'it-security'),
		'type'     => 'checkbox',
	));		

	$wp_customize->add_setting('it_security_metafields_time', array(
		'default' => true,
		'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control('it_security_metafields_time', array(
		'settings' => 'it_security_metafields_time',
		'section'  => 'it_security_blog_post_settings',
		'label'    => __('Check to Enable Time', 'it-security'),
		'type'     => 'checkbox',
	));	

	$wp_customize->add_setting('it_security_metabox_seperator',array(
		'default' => '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_metabox_seperator',array(
		'type' => 'text',
		'label' => __('Metabox Seperator','it-security'),
		'description' => __('Ex: "/", "|", "-", ...','it-security'),
		'section' => 'it_security_blog_post_settings'
	)); 

    // Add Settings and Controls for Post Layout
	$wp_customize->add_setting('it_security_sidebar_post_layout',array(
		'default' => 'right',
		'sanitize_callback' => 'it_security_sanitize_choices'
	));
	$wp_customize->add_control('it_security_sidebar_post_layout',array(
		'type' => 'radio',
		'label'     => __('Theme Post Sidebar Position', 'it-security'),
		'description'   => __('This option work for blog page, archive page and search page.', 'it-security'),
		'section' => 'it_security_blog_post_settings',
		'choices' => array(
			'full' => __('Full','it-security'),
			'left' => __('Left','it-security'),
			'right' => __('Right','it-security'),
			'three-column' => __('Three Columns','it-security'),
			'four-column' => __('Four Columns','it-security'),
			'grid' => __('Grid Layout','it-security')
     ),
	) );

	$wp_customize->add_setting('it_security_blog_post_description_option',array(
    	'default'   => 'Excerpt Content', 
        'sanitize_callback' => 'it_security_sanitize_choices'
	));
	$wp_customize->add_control('it_security_blog_post_description_option',array(
        'type' => 'radio',
        'label' => __('Post Description Length','it-security'),
        'section' => 'it_security_blog_post_settings',
        'choices' => array(
            'No Content' => __('No Content','it-security'),
            'Excerpt Content' => __('Excerpt Content','it-security'),
            'Full Content' => __('Full Content','it-security'),
        ),
	) );

	$wp_customize->add_setting('it_security_blog_post_thumb',array(
        'sanitize_callback' => 'it_security_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('it_security_blog_post_thumb',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Show / Hide Blog Post Thumbnail', 'it-security'),
        'section'     => 'it_security_blog_post_settings',
    ));

	$wp_customize->add_setting( 'it_security_blog_post_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_blog_post_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_blog_post_settings'
	));

	//Single Post Settings
	$wp_customize->add_section('it_security_single_post_settings',array(
		'title' => __('Manage Single Post Section', 'it-security'),
		'priority' => null,
		'panel' => 'it_security_panel_area'
	));

	$wp_customize->add_setting('it_security_single_post_date',array(
		'default' => true,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
	));
	$wp_customize->add_control('it_security_single_post_date',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Date ','it-security'),
		'section' => 'it_security_single_post_settings'
	));	

	$wp_customize->add_setting('it_security_single_post_author',array(
		'default' => true,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
	));
	$wp_customize->add_control('it_security_single_post_author',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Author','it-security'),
		'section' => 'it_security_single_post_settings'
	));

	$wp_customize->add_setting('it_security_single_post_comment',array(
		'default' => true,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
	));
	$wp_customize->add_control('it_security_single_post_comment',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Comments','it-security'),
		'section' => 'it_security_single_post_settings'
	));	

	$wp_customize->add_setting('it_security_single_post_time',array(
		'default' => true,
		'sanitize_callback'	=> 'it_security_sanitize_checkbox'
	));
	$wp_customize->add_control('it_security_single_post_time',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Time','it-security'),
		'section' => 'it_security_single_post_settings'
	));	

	$wp_customize->add_setting('it_security_single_post_metabox_seperator',array(
		'default' => '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_single_post_metabox_seperator',array(
		'type' => 'text',
		'label' => __('Metabox Seperator','it-security'),
		'description' => __('Ex: "/", "|", "-", ...','it-security'),
		'section' => 'it_security_single_post_settings'
	)); 

	$wp_customize->add_setting('it_security_sidebar_single_post_layout',array(
    	'default' => 'right',
    	 'sanitize_callback' => 'it_security_sanitize_choices'
	));
	$wp_customize->add_control('it_security_sidebar_single_post_layout',array(
   		'type' => 'radio',
    	'label'     => __('Single post sidebar layout', 'it-security'),
     	'section' => 'it_security_single_post_settings',
     	'choices' => array(
			'full' => __('Full','it-security'),
			'left' => __('Left','it-security'),
			'right' => __('Right','it-security'),
     ),
	));

	$wp_customize->add_setting( 'it_security_single_post_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_single_post_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_single_post_settings'
	));

	//Page Settings
	$wp_customize->add_section('it_security_page_settings',array(
		'title' => __('Manage Page Section', 'it-security'),
		'priority' => null,
		'panel' => 'it_security_panel_area'
	));

	// Add Settings and Controls for Page Layout
	$wp_customize->add_setting('it_security_sidebar_page_layout',array(
		'default' => 'full',
			'sanitize_callback' => 'it_security_sanitize_choices'
	));
	$wp_customize->add_control('it_security_sidebar_page_layout',array(
		'type' => 'radio',
		'label'     => __('Theme Page Sidebar Position', 'it-security'),
		'section' => 'it_security_page_settings',
		'choices' => array(
			'left' => __('Left','it-security'),
			'right' => __('Right','it-security'),
			'full' => __('No Sidebar','it-security')
		),
	));	

	$wp_customize->add_setting( 'it_security_page_layout_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_page_layout_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
		<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_page_settings'
	));

	// 404 Page Settings
	$wp_customize->add_section('it_security_page_not_found', array(
		'title'	=> __('Manage 404 Page Section','it-security'),
		'priority'	=> null,
		'panel' => 'it_security_panel_area',
	));
	
	$wp_customize->add_setting('it_security_page_not_found_heading',array(
		'default'=> __('404 Not Found','it-security'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_page_not_found_heading',array(
		'label'	=> __('404 Heading','it-security'),
		'section'=> 'it_security_page_not_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('it_security_page_not_found_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('it_security_page_not_found_content',array(
		'label'	=> __('404 Text','it-security'),
		'input_attrs' => array(
			'placeholder' => __( 'Looks like you have taken a wrong turn.....Don\'t worry... it happens to the best of us.', 'it-security' ),
		),
		'section'=> 'it_security_page_not_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('it_security_page_not_found_btn',array(
		'default' => 'Homepage',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_page_not_found_btn', array(
	   'settings' => 'it_security_page_not_found_btn',
	   'section'   => 'it_security_page_not_found',
	   'label' => __('404 Button', 'it-security'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting( 'it_security_page_not_found_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_page_not_found_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
		<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_page_not_found'
	));

	// Footer Section
	$wp_customize->add_section('it_security_footer', array(
		'title'	=> __('Manage Footer Section','it-security'),
		'description'	=> __('<p class="sec-title">Manage Footer Section</p>','it-security'),
		'priority'	=> null,
		'panel' => 'it_security_panel_area',
	));

	$wp_customize->add_setting('it_security_footer_widget', array(
	    'default' => true,
	    'sanitize_callback' => 'it_security_sanitize_checkbox',
	));
	$wp_customize->add_control('it_security_footer_widget', array(
	    'settings' => 'it_security_footer_widget',
	    'section'   => 'it_security_footer',
	    'label'     => __('Check to Enable Footer Widget', 'it-security'),
	    'type'      => 'checkbox',
	));

	//  footer bg color
	$wp_customize->add_setting('it_security_footerbg_color',array(
		'default' => '',
		'sanitize_callback' => 'it_security_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footerbg_color', array(
		'settings' => 'it_security_footerbg_color',
		'section'   => 'it_security_footer',
		'label' => __('Footer Background Color', 'it-security'),
		'type'      => 'color'
	));

	$wp_customize->add_setting('it_security_footer_bg_image',array(
        'default'   => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'it_security_footer_bg_image',array(
        'label' => __('Footer Background Image','it-security'),
        'section' => 'it_security_footer',
    )));

	$wp_customize->add_setting('it_security_footer_img_position',array(
		'default' => 'center center',
		'transport' => 'refresh',
		'sanitize_callback' => 'it_security_sanitize_choices'
	));
	$wp_customize->add_control('it_security_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','it-security'),
		'section' => 'it_security_footer',
		'choices' 	=> array(
			'center center'   => esc_html__( 'Center', 'it-security' ),
			'center top'   => esc_html__( 'Top', 'it-security' ),
			'left center'   => esc_html__( 'Left', 'it-security' ),
			'right center'   => esc_html__( 'Right', 'it-security' ),
			'center bottom'   => esc_html__( 'Bottom', 'it-security' ),
		),
	));	

	$wp_customize->add_setting('it_security_footer_widget_areas',array(
		'default'           => 4,
		'sanitize_callback' => 'it_security_sanitize_choices',
	));
	$wp_customize->add_control('it_security_footer_widget_areas',array(
		'type'        => 'radio',
		'section' => 'it_security_footer',
		'label'       => __('Footer widget area', 'it-security'),
		'choices' => array(
		   '1'     => __('One', 'it-security'),
		   '2'     => __('Two', 'it-security'),
		   '3'     => __('Three', 'it-security'),
		   '4'     => __('Four', 'it-security')
		),
	));

	$wp_customize->add_setting('it_security_copyright_line',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control( 'it_security_copyright_line', array(
	   'section' 	=> 'it_security_footer',
	   'label'	 	=> __('Copyright Line','it-security'),
	   'type'    	=> 'text',
	   'priority' 	=> null,
    ));

	$wp_customize->add_setting('it_security_copyright_link',array(
    	'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control( 'it_security_copyright_link', array(
	   'section' 	=> 'it_security_footer',
	   'label'	 	=> __('Copyright Link','it-security'),
	   'type'    	=> 'text',
	   'priority' 	=> null,
    ));

	//  footer title color
	$wp_customize->add_setting('it_security_footertitle_color',array(
		'default' => '',
		'sanitize_callback' => 'it_security_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footertitle_color', array(
	   'settings' => 'it_security_footertitle_color',
	   'section'   => 'it_security_footer',
	   'label' => __('Title Color', 'it-security'),
	   'type'      => 'color'
	));

	//  footer list color
	$wp_customize->add_setting('it_security_footerlist_color',array(
		'default' => '',
		'sanitize_callback' => 'it_security_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footerlist_color', array(
	   'settings' => 'it_security_footerlist_color',
	   'section'   => 'it_security_footer',
	   'label' => __('List Color', 'it-security'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('it_security_scroll_hide', array(
        'default' => true,
        'sanitize_callback' => 'it_security_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'it_security_scroll_hide',array(
        'label'          => __( 'Check To Show Scroll To Top', 'it-security' ),
        'section'        => 'it_security_footer',
        'settings'       => 'it_security_scroll_hide',
        'type'           => 'checkbox',
    )));

	$wp_customize->add_setting('it_security_scroll_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'it_security_sanitize_choices'
    ));
    $wp_customize->add_control('it_security_scroll_position',array(
        'type' => 'radio',
        'section' => 'it_security_footer',
        'label'	 	=> __('Scroll To Top Positions','it-security'),
        'choices' => array(
            'Right' => __('Right','it-security'),
			'Left' => __('Left','it-security'),
            'Center' => __('Center','it-security')
        ),
    ) );

	$wp_customize->add_setting('it_security_scroll_text',array(
		'default'	=> __('TOP','it-security'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));	
	$wp_customize->add_control('it_security_scroll_text',array(
		'label'	=> __('Scroll To Top Button Text','it-security'),
		'section'	=> 'it_security_footer',
		'type'		=> 'text'
	));

	$wp_customize->add_setting( 'it_security_scroll_top_shape', array(
		'default'           => 'circle',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'it_security_scroll_top_shape', array(
		'label'    => __( 'Scroll to Top Button Shape', 'it-security' ),
		'section'  => 'it_security_footer',
		'settings' => 'it_security_scroll_top_shape',
		'type'     => 'radio',
		'choices'  => array(
			'box'        => __( 'Box', 'it-security' ),
			'curved' => __( 'Curved', 'it-security'),
			'circle'     => __( 'Circle', 'it-security' ),
		),
	) );

	$wp_customize->add_setting( 'it_security_footer_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_footer_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
			<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_footer'
	));

	// Footer Social Section
	$wp_customize->add_section('it_security_footer_social_icons', array(
		'title'	=> __('Manage Footer Social Section','it-security'),
		'description'	=> __('<p class="sec-title">Manage Footer Social Section</p>','it-security'),
		'priority'	=> null,
		'panel' => 'it_security_panel_area',
	));

	$wp_customize->add_setting('it_security_footer_facebook_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footer_facebook_link', array(
		'settings' => 'it_security_footer_facebook_link',
		'section'   => 'it_security_footer_social_icons',
		'label' => __('Facebook Link', 'it-security'),
		'type'      => 'url'
	));

	$wp_customize->add_setting('it_security_footer_instagram_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footer_instagram_link', array(
		'settings' => 'it_security_footer_instagram_link',
		'section'   => 'it_security_footer_social_icons',
		'label' => __('Instagram Link', 'it-security'),
		'type'      => 'url'
	));

	$wp_customize->add_setting('it_security_footer_pinterest_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footer_pinterest_link', array(
		'settings' => 'it_security_footer_pinterest_link',
		'section'   => 'it_security_footer_social_icons',
		'label' => __('Pinterest Link', 'it-security'),
		'type'      => 'url'
	));

	$wp_customize->add_setting('it_security_footer_twitter_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footer_twitter_link', array(
		'settings' => 'it_security_footer_twitter_link',
		'section'   => 'it_security_footer_social_icons',
		'label' => __('Twitter Link', 'it-security'),
		'type'      => 'url'
	));

	$wp_customize->add_setting('it_security_footer_youtube_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'it_security_footer_youtube_link', array(
		'settings' => 'it_security_footer_youtube_link',
		'section'   => 'it_security_footer_social_icons',
		'label' => __('Youtube Link', 'it-security'),
		'type'      => 'url'
	));

	$wp_customize->add_setting( 'it_security_footer_social_settings_upgraded_features',array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('it_security_footer_social_settings_upgraded_features', array(
		'type'=> 'hidden',
		'description' => "<span class='customizer-upgraded-features'>Unlock Premium Customization Features:
		<a target='_blank' href='". esc_url(IT_SECURITY_PREMIUM_PAGE) ." '>Upgrade to Pro</a></span>",
		'section' => 'it_security_footer_social_icons'
	));
    
	// Google Fonts
	$wp_customize->add_section( 'it_security_google_fonts_section', array(
		'title'       => __( 'Google Fonts', 'it-security' ),
		'priority'    => 24,
	) );

	$font_choices = array(
		'Kaushan Script:' => 'Kaushan Script',
		'Emilys Candy:' => 'Emilys Candy',
		'Poppins:0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900' => 'Poppins',
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Montserrat:400,700' => 'Montserrat',
		'Raleway:400,700' => 'Raleway',
		'Droid Sans:400,700' => 'Droid Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Oxygen:400,300,700' => 'Oxygen',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Cabin:400,700,400italic' => 'Cabin',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Bitter:400,700,400italic' => 'Bitter',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
		'Rokkitt:400' => 'Rokkitt',
	);

	$wp_customize->add_setting( 'it_security_headings_fonts', array(
		'sanitize_callback' => 'it_security_sanitize_fonts',
	));
	$wp_customize->add_control( 'it_security_headings_fonts', array(
		'type' => 'select',
		'description' => __('Select your desired font for the headings.', 'it-security'),
		'section' => 'it_security_google_fonts_section',
		'choices' => $font_choices
	));

	$wp_customize->add_setting( 'it_security_body_fonts', array(
		'sanitize_callback' => 'it_security_sanitize_fonts'
	));
	$wp_customize->add_control( 'it_security_body_fonts', array(
		'type' => 'select',
		'description' => __( 'Select your desired font for the body.', 'it-security' ),
		'section' => 'it_security_google_fonts_section',
		'choices' => $font_choices
	));
  
}
add_action( 'customize_register', 'it_security_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function it_security_customize_preview_js() {
	wp_enqueue_script( 'it_security_customizer', esc_url(get_template_directory_uri()) . '/js/customize-preview.js', array( 'customize-preview' ), '20161510', true );
}
add_action( 'customize_preview_init', 'it_security_customize_preview_js' );
