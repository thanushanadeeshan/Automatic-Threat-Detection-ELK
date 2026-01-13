<?php
/**
 * @package IT Security
 * Setup the WordPress core custom header feature.
 *
 * @uses it_security_header_style()
 */
function it_security_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'it_security_custom_header_args', array(
		'default-text-color'     => 'fff',
		'width'                  => 2500,
		'height'                 => 300,
		'wp-head-callback'       => 'it_security_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'it_security_custom_header_setup' );

if ( ! function_exists( 'it_security_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see it_security_custom_header_setup().
 */
function it_security_header_style() {
    $it_security_header_image = get_header_image() ?: get_template_directory_uri() . '/images/headerimg.png';

    $it_security_custom_css = "
        .box-image .single-page-img {
            background-image: url('{$it_security_header_image}');
            background-repeat: no-repeat;
            background-position: center bottom;
            background-size: cover !important;
            height: 300px;
        }

        h1.site-title a, p.site-title a {
            color: " . esc_attr(get_theme_mod('it_security_sitetitle_color')) . " !important;
        }

        .site-description {
            color: " . esc_attr(get_theme_mod('it_security_sitetagline_color')) . " !important;
        }

        .main-nav ul li a {
            color: " . esc_attr(get_theme_mod('it_security_menu_color')) . " !important;
        }

        .main-nav a:hover {
            color: " . esc_attr(get_theme_mod('it_security_menuhrv_color')) . " !important;
        }

        .main-nav ul ul a {
            color: " . esc_attr(get_theme_mod('it_security_submenu_color')) . " !important;
        }

        .main-nav ul ul a:hover {
            color: " . esc_attr(get_theme_mod('it_security_submenuhrv_color')) . " !important;
        }

        #footer h3 {
            color: " . esc_attr(get_theme_mod('it_security_footertitle_color')) . " !important;
        }

        #footer ul li a {
            color: " . esc_attr(get_theme_mod('it_security_footerlist_color')) . ";
        }

        #footer {
            background-color: " . esc_attr(get_theme_mod('it_security_footerbg_color')) . ";
        }
    ";

    // Attach to your main stylesheet (make sure this handle matches the one you registered)
    wp_add_inline_style('it-security-style', $it_security_custom_css);
}
endif;
add_action('wp_enqueue_scripts', 'it_security_header_style');