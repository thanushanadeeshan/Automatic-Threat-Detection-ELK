<?php
/*
 * @package IT Security
 */


 function it_security_admin_enqueue_scripts() {
    wp_enqueue_style( 'it-security-admin-style', esc_url( get_template_directory_uri() ).'/css/addon.css' );
}
add_action( 'admin_enqueue_scripts', 'it_security_admin_enqueue_scripts' );

function it_security_theme_info_menu_link() {

    $it_security_theme = wp_get_theme();
    add_theme_page(
        /* translators: 1: Theme name. */
        sprintf( esc_html__( 'Welcome to %1$s', 'it-security' ), $it_security_theme->get( 'Name' )),
        esc_html__( 'Theme Demo Import', 'it-security' ),
        'edit_theme_options',
        'it-security',
        'it_security_theme_info_page'
    );
}
add_action( 'admin_menu', 'it_security_theme_info_menu_link' );

function it_security_theme_info_page() {

    $it_security_theme = wp_get_theme();
    ?>
<div class="wrap theme-info-wrap">
    <h1><?php printf( esc_html__( 'Welcome to %1$s', 'it-security' ), esc_html($it_security_theme->get( 'Name' ))); ?>
    </h1>
    <p class="theme-description">
    <?php esc_html_e( 'Do you want to configure this theme? Look no further, our easy-to-follow theme documentation will walk you through it.', 'it-security' ); ?>
    </p>
    <div class="columns-wrapper clearfix theme-demo">
        <div class="column column-quarter clearfix start-box"> 
            <div class="demo-import">
                <div class="theme-name">
                    <h2><?php echo esc_html( $it_security_theme->get( 'Name' ) ); ?></h2>
                    <p class="version"><?php esc_html_e( 'Version', 'it-security' ); ?>: <?php echo esc_html( wp_get_theme()->get( 'Version' ) ); ?></p>	
                </div>
                <?php
                    $it_security_demo_content_file = apply_filters(
                        'it_security_demo_content_path',
                        get_parent_theme_file_path( '/inc/demo-content.php' )
                    );
                    require $it_security_demo_content_file;             
                ?>               
                <div id="demo-import-loader">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/status.gif'); ?>" alt="<?php echo esc_attr( 'Loading...', 'it-security'); ?>" />
                </div>
            </div>
        </div>
        <div class="column column-half clearfix">
            <div class="important-link">
                <div class="main-box columns-wrapper clearfix">

                    <div class="themelink column column-half column-border clearfix">
                        <p><strong><?php esc_html_e( 'Free Theme Documentation', 'it-security' ); ?></strong></p>
                        <p><?php esc_html_e( 'Need more details? Please check our full documentation for detailed theme setup.', 'it-security' ); ?></p>
                        <a href="<?php echo esc_url( IT_SECURITY_THEME_DOCUMENTATION ); ?>" target="_blank">
                        <?php esc_html_e( 'Documentation', 'it-security' ); ?>
                        </a>
                    </div>

                    <div class="themelink column column-half column-padding clearfix">
                        <p><strong><?php esc_html_e( 'Need Help?', 'it-security' ); ?></strong></p>
                        <p><?php esc_html_e( 'Go to our support forum to help you out in case of queries and doubts regarding our theme.', 'it-security' ); ?></p>
                        <a href="<?php echo esc_url( IT_SECURITY_SUPPORT ); ?>" target="_blank">
                        <?php esc_html_e( 'Contact Us', 'it-security' ); ?>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="main-box columns-wrapper clearfix">

                    <div class="themelink column column-half column-border clearfix">
                        <p><strong><?php esc_html_e( 'Pro version of our theme', 'it-security' ); ?></strong></p>
                        <p><?php esc_html_e( 'Are you excited for our theme? Then we will proceed for pro version of theme.', 'it-security' ); ?></p>
                        <a class="get-premium" href="<?php echo esc_url( IT_SECURITY_PREMIUM_PAGE ); ?>" target="_blank">
                        <?php esc_html_e( 'Get Premium', 'it-security' ); ?>
                        </a>
                    </div>

                    <div class="themelink column column-half column-padding clearfix">
                        <p><strong><?php esc_html_e( 'Leave us a review', 'it-security' ); ?></strong></p>
                        <p><?php esc_html_e( 'Are you enjoying our theme? We would love to hear your feedback.', 'it-security' ); ?></p>
                        <a href="<?php echo esc_url( IT_SECURITY_REVIEW ); ?>" target="_blank">
                        <?php esc_html_e( 'Rate This Theme', 'it-security' ); ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="column column-quarter clearfix start-box"> 
            <div class="bundle-info">
                <img src="<?php echo esc_url( get_template_directory_uri().'/images/bundle.png'); ?>" alt="<?php echo esc_attr( 'screenshot', 'it-security'); ?>" class="bundle-image"/>
                <div class="bundle-content themelink">
                    <h3><?php esc_html_e( 'WordPress Theme Bundle', 'it-security' ); ?></h3>
                    <small><b><?php esc_html_e( 'Get access to a collection of 100+ stunning WordPress themes for just $99 — featuring designs for every business niche!', 'it-security' ); ?></small></b>
                    <a class="get-premium" href="<?php echo esc_url( IT_SECURITY_BUNDLE_PAGE ); ?>" target="_blank">
                    <?php esc_html_e( 'Get Bundle at 20% OFF', 'it-security' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="getting-started">
        <div class="section">
            <h3><?php 
            /* translators: %s: Theme name. */
            printf( esc_html__( 'Getting started with %s', 'it-security' ),
            esc_html($it_security_theme->get( 'Name' ))); ?></h3>
            <div class="columns-wrapper clearfix">
                <div class="column column-half clearfix">
                    <div class="section themelink">
                        <div class="">
                            <a class="" href="<?php echo esc_url( IT_SECURITY_PREMIUM_PAGE ); ?>" target="_blank"><?php esc_html_e( 'Get Premium', 'it-security' ); ?></a>
                            <a href="<?php echo esc_url( IT_SECURITY_PRO_DEMO ); ?>" target="_blank"><?php esc_html_e( 'View Demo', 'it-security' ); ?></a>
                            <a class="get-premium" href="<?php echo esc_url( IT_SECURITY_BUNDLE_PAGE ); ?>" target="_blank"><?php esc_html_e( 'Bundle of 100+ Themes at $99', 'it-security' ); ?></a>
                        </div>
                        <div class="theme-description-1"><?php echo esc_html($it_security_theme->get( 'Description' )); ?></div>
                    </div>
                </div>
                <div class="column column-half clearfix">
                    <img src="<?php echo esc_url( $it_security_theme->get_screenshot() ); ?>" alt="<?php echo esc_attr( 'screenshot', 'it-security'); ?>"/>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div id="theme-author">
      <p><?php
        /* translators: 1: Theme name, 2: Author name, 3: Call to action text. */
        printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'it-security' ),
            esc_html($it_security_theme->get( 'Name' )),
            '<a target="_blank" href="' . esc_url( 'https://www.theclassictemplates.com/', 'it-security' ) . '">classictemplate</a>',
            '<a target="_blank" href="' . esc_url(IT_SECURITY_REVIEW ) . '" title="' . esc_attr__( 'Rate it', 'it-security' ) . '">' . esc_html_x( 'rate it', 'If you like this theme, rate it', 'it-security' ) . '</a>'
        );
        ?></p>
    </div>
</div>
<?php
}
?>