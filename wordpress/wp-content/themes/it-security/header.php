<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package IT Security
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( function_exists( 'wp_body_open' ) ) {
  wp_body_open();
} else {
  do_action( 'wp_body_open' );
} ?>

<?php if ( get_theme_mod('it_security_preloader', false) != "") { ?>
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
<?php }?>

<a class="screen-reader-text skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'it-security' ); ?></a>

<div id="pageholder" <?php if( get_theme_mod( 'it_security_box_layout', false) != "" ) { echo 'class="boxlayout"'; } ?>>

<div class="mainhead<?php if( get_theme_mod( 'it_security_stickyheader', false) == 1) { ?> is-sticky-on"<?php } else { ?>close-sticky <?php } ?>">
  <div class="main-header">
    <div class="container">
      <?php if (get_theme_mod('it_security_topbar_text') != "") { ?>
        <div class="topbar py-2 px-5">
          <p class="topbar-text text-center mb-0 text-capitalize"><i class="fa-solid fa-bullhorn me-2"></i><?php echo esc_html(get_theme_mod('it_security_topbar_text')); ?></p>
        </div>
      <?php }?>
      <div class="menu-header position-relative py-2">
        <div class="row">
          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12 align-self-center">
            <div class="logo">
              <?php if (get_theme_mod('it_security_logo_enable', true)) { ?>
                <?php it_security_the_custom_logo(); ?>
              <?php } ?>
              <div class="site-branding-text">
                <?php if (get_theme_mod('it_security_title_enable', false)) { ?>
                  <?php if (is_front_page() && is_home()) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
                  <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
                  <?php endif; ?>
                <?php } ?>
                <?php $it_security_description = get_bloginfo('description', 'display');
                if ($it_security_description || is_customize_preview()) : ?>
                  <?php if (get_theme_mod('it_security_tagline_enable', false)) { ?>
                    <span class="site-description"><?php echo esc_html($it_security_description); ?></span>
                  <?php } ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-8 col-sm-4 col-5 align-self-center">
            <div class="menu-sec">
              <div class="toggle-nav text-start ps-1">
                <?php if (has_nav_menu('primary')) { ?>
                  <button role="tab"><?php esc_html_e('Menu', 'it-security'); ?></button>
                <?php } ?>
              </div>
              <div id="mySidenav" class="nav sidenav">
                <nav id="site-navigation" class="main-nav" role="navigation" aria-label="<?php esc_attr_e('Top Menu', 'it-security'); ?>">
                  <ul class="mobile_nav">
                    <?php wp_nav_menu(array(
                      'theme_location' => 'primary',
                      'container_class' => 'main-menu',
                      'items_wrap' => '%3$s',
                      'fallback_cb' => 'wp_page_menu',
                    )); ?>
                  </ul>
                  <a href="javascript:void(0)" class="close-button"><?php esc_html_e('CLOSE', 'it-security'); ?></a>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-5 col-7 align-self-center text-end">
            <?php if (get_theme_mod('it_security_header_user_link') != "") { ?>
              <div class="user-box">
                <a href="<?php echo esc_attr( get_theme_mod('it_security_header_user_link')); ?>"><i class="fa-solid fa-user"></i></a>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>