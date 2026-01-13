<?php
/**
 * IT Security functions and definitions
 *
 * @package IT Security
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'it_security_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function it_security_setup() {
	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 680;
	
	load_theme_textdomain( 'it-security', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'align-wide' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'wp-block-styles');
	add_theme_support( 'custom-header', array(
		'default-text-color' => false,
		'header-text' => false,
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 100,
		'flex-height' => true,
	) );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'it-security' ),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

	add_editor_style( 'editor-style.css' );

	global $pagenow;

    if ( is_admin() && 'themes.php' === $pagenow && isset( $_GET['activated'] ) && current_user_can( 'manage_options' ) ) {
        add_action('admin_notices', 'it_security_deprecated_hook_admin_notice');
    }
}
endif; // it_security_setup
add_action( 'after_setup_theme', 'it_security_setup' );

function it_security_the_breadcrumb() {
    echo '<div class="breadcrumb my-3">';

    if (!is_home()) {
        echo '<a class="home-main align-self-center" href="' . esc_url(home_url()) . '">';
        bloginfo('name');
        echo "</a> >> ";

        if (is_category() || is_single()) {
            the_category(' >> ');
            if (is_single()) {
                echo ' >> <span class="current-breadcrumb">' . esc_html(get_the_title()) . '</span>';
            }
        } elseif (is_page()) {
            echo '<span class="current-breadcrumb">' . esc_html(get_the_title()) . '</span>';
        }
    }

    echo '</div>';
}

function it_security_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'it-security' ),
		'description'   => __( 'Appears on blog page sidebar', 'it-security' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'it-security' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your sidebar on pages.', 'it-security' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'it-security' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'it-security' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar(array(
        'name'          => __('Shop Sidebar', 'it-security'),
        'description'   => __('Sidebar for WooCommerce shop pages', 'it-security'),
		'id'            => 'woocommerce-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
	register_sidebar(array(
        'name'          => __('Single Product Sidebar', 'it-security'),
        'description'   => __('Sidebar for single product pages', 'it-security'),
		'id'            => 'woocommerce-single-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));		
	
	$it_security_widget_areas = get_theme_mod('it_security_footer_widget_areas', '4');
	for ($it_security_i=1; $it_security_i<=$it_security_widget_areas; $it_security_i++) {
		register_sidebar( array(
			'name'          => __( 'Footer Widget ', 'it-security' ) . $it_security_i,
			'id'            => 'footer-' . $it_security_i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-4 %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

}
add_action( 'widgets_init', 'it_security_widgets_init' );

// Change number of products per row to 4
add_filter('loop_shop_columns', 'it_security_loop_columns');
if (!function_exists('it_security_loop_columns')) {
    function it_security_loop_columns() {
        $colm = get_theme_mod('it_security_products_per_row', 4); // Default to 4 if not set
        return $colm;
    }
}

// Use the customizer setting to set the number of products per page
function it_security_products_per_page($cols) {
    $cols = get_theme_mod('it_security_products_per_page', 8); // Default to 8 if not set
    return $cols;
}
add_filter('loop_shop_per_page', 'it_security_products_per_page', 8);

function it_security_scripts() {
	
	wp_enqueue_style( 'bootstrap-css', esc_url(get_template_directory_uri())."/css/bootstrap.css" );
	wp_enqueue_style('it-security-style', get_stylesheet_uri(), array() );
		wp_style_add_data('it-security-style', 'rtl', 'replace');
	require get_parent_theme_file_path( '/inc/color-scheme/custom-color-control.php' );
	wp_add_inline_style( 'it-security-style',$it_security_color_scheme_css );
	wp_enqueue_style( 'owl.carousel-css', esc_url(get_template_directory_uri())."/css/owl.carousel.css" );
	wp_enqueue_style( 'it-security-default', esc_url(get_template_directory_uri())."/css/default.css" );
	wp_enqueue_style( 'it-security-style', get_stylesheet_uri() );
	wp_enqueue_script( 'owl.carousel-js', esc_url(get_template_directory_uri()). '/js/owl.carousel.js', array('jquery') );
	wp_enqueue_script( 'bootstrap-js', esc_url(get_template_directory_uri()). '/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'it-security-theme', esc_url(get_template_directory_uri()) . '/js/theme.js' );
	wp_enqueue_style( 'font-awesome-css', esc_url(get_template_directory_uri())."/css/fontawesome-all.css" );
	wp_enqueue_style( 'it-security-block-style', esc_url( get_template_directory_uri() ).'/css/blocks.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// font-family
    $it_security_body_font = esc_html(get_theme_mod('it_security_body_fonts'));

    if ($it_security_body_font) {
        wp_enqueue_style('it-security-body-fonts', 'https://fonts.googleapis.com/css?family=' . urlencode($it_security_body_font));
    } else {
        wp_enqueue_style('Syne', 'https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800');
    }
}
add_action( 'wp_enqueue_scripts', 'it_security_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Sanitization Callbacks.
 */
require get_template_directory() . '/inc/sanitization-callbacks.php';

/**
 * Webfont-Loader.
 */
require get_template_directory() . '/inc/wptt-webfont-loader.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/upgrade-to-pro.php';

/**
 * Google Fonts
 */
require get_template_directory() . '/inc/gfonts.php';

/**
 * select .
 */
require get_template_directory() . '/inc/select/category-dropdown-custom-control.php';

/**
 * Load TGM.
 */
require get_template_directory() . '/inc/tgm/tgm.php';

/**
 * Theme Info Page.
 */
require get_template_directory() . '/inc/addon.php';

function it_security_setup_theme() {

	if ( ! defined( 'IT_SECURITY_PREMIUM_PAGE' ) ) {
		define('IT_SECURITY_PREMIUM_PAGE',__('https://www.theclassictemplates.com/products/cybersecurity-wordpress-theme','it-security'));
	}
	if ( ! defined( 'IT_SECURITY_THEME_PAGE' ) ) {
		define('IT_SECURITY_THEME_PAGE',__('https://www.theclassictemplates.com/collections/best-wordpress-templates','it-security'));
	}
	if ( ! defined( 'IT_SECURITY_SUPPORT' ) ) {
		define('IT_SECURITY_SUPPORT',__('https://wordpress.org/support/theme/it-security/','it-security'));
	}
	if ( ! defined( 'IT_SECURITY_REVIEW' ) ) {
		define('IT_SECURITY_REVIEW',__('https://wordpress.org/support/theme/it-security/reviews/','it-security'));
	}
	if ( ! defined( 'IT_SECURITY_PRO_DEMO' ) ) {
		define('IT_SECURITY_PRO_DEMO',__('https://live.theclassictemplates.com/it-security-pro/','it-security'));
	}
	if ( ! defined( 'IT_SECURITY_THEME_DOCUMENTATION' ) ) {
		define('IT_SECURITY_THEME_DOCUMENTATION',__('https://live.theclassictemplates.com/demo/docs/it-security-free/','it-security'));
	}
	if ( ! defined( 'IT_SECURITY_BUNDLE_PAGE' ) ) {
		define('IT_SECURITY_BUNDLE_PAGE',__('https://www.theclassictemplates.com/products/wordpress-theme-bundle','it-security'));
	}
}
add_action('after_setup_theme', 'it_security_setup_theme');
    
// logo
if ( ! function_exists( 'it_security_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function it_security_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/* Activation Notice */
function it_security_deprecated_hook_admin_notice() {
    $it_security_theme = wp_get_theme();
    $it_security_dismissed = get_user_meta( get_current_user_id(), 'it_security_dismissable_notice', true );
    if ( !$it_security_dismissed) { ?>
        <div class="getstrat updated notice notice-success is-dismissible notice-get-started-class">
            <div class="admin-image">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()) .'/screenshot.png'; ?>" />
            </div>
            <div class="admin-content" >
                <h1><?php 
				/* translators: 1: Theme name, 2: Theme version. */
				printf( esc_html__( 'Welcome to %1$s %2$s', 'it-security' ), esc_html($it_security_theme->get( 'Name' )), esc_html($it_security_theme->get( 'Version' ))); ?>
                </h1>
                <p><?php _e('Get Started With Theme By Clicking On Getting Started.', 'it-security'); ?></p>
                <div style="display: grid;">
                    <a class="admin-notice-btn button button-hero upgrade-pro" target="_blank" href="<?php echo esc_url( IT_SECURITY_PREMIUM_PAGE ); ?>"><?php esc_html_e('Upgrade Pro', 'it-security') ?><i class="dashicons dashicons-cart"></i></a>
                    <a class="admin-notice-btn button button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=it-security' )); ?>"><?php esc_html_e( 'Get started', 'it-security' ) ?><i class="dashicons dashicons-backup"></i></a>
                    <a class="admin-notice-btn button button-hero" target="_blank" href="<?php echo esc_url( IT_SECURITY_THEME_DOCUMENTATION ); ?>"><?php esc_html_e('Free Doc', 'it-security') ?><i class="dashicons dashicons-visibility"></i></a>
                    <a  class="admin-notice-btn button button-hero" target="_blank" href="<?php echo esc_url( IT_SECURITY_PRO_DEMO ); ?>"><?php esc_html_e('View Demo', 'it-security') ?><i class="dashicons dashicons-awards"></i></a>
                </div>
            </div>
			<div class="admin-bundle-image">
            	<a href="<?php echo esc_url( IT_SECURITY_BUNDLE_PAGE ); ?>" target="_blank"><img src="<?php echo esc_url(get_stylesheet_directory_uri()) .'/images/image_1.webp'; ?>" /></a>
            </div>
        </div>
    <?php }
}