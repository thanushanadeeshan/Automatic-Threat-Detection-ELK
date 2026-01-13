<?php
/**
 * The Template Name: Home Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package IT Security
 */

get_header(); ?>

<div id="content" >
    <?php
        $it_security_banner_bg_image = file_get_contents(get_template_directory_uri() . '/images/banner-img.svg');
        $it_security_banner = get_theme_mod('it_security_banner', false);
        $it_security_banner_pageboxes = get_theme_mod('it_security_banner_pageboxes', false);

        if ($it_security_banner && $it_security_banner_pageboxes) { ?>
        <div id="banner-cat" class="position-relative">
            <?php
            $it_security_querymed = new WP_Query(array(
                'page_id' => esc_attr($it_security_banner_pageboxes)
            ));
            while ($it_security_querymed->have_posts()) : $it_security_querymed->the_post(); ?>
                <div class="container">
                    <div class="banner-bg position-relative text-center">
                        <?php echo $it_security_banner_bg_image; ?>
                        <div class="bannerbox text-center position-absolute">
                            <h1 class="mb-3 text-uppercase banner-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                            <?php
                                $it_security_trimexcerpt = get_the_excerpt();
                                $it_security_shortexcerpt = wp_trim_words($it_security_trimexcerpt, 38);
                                echo '<p class="banner-content">' . esc_html($it_security_shortexcerpt) . '</p>';
                            ?>
                            <div class="bannerbtn position-relative">
                                <div class="banner-inner-btn p-2">
                                    <?php
                                        $it_security_button_text = get_theme_mod('it_security_button_text', 'Explore More');
                                        $it_security_button_link_banner = esc_url(get_theme_mod('it_security_button_link_banner', get_permalink()));
                                        if ($it_security_button_text || !empty($it_security_button_link_banner)) { ?>
                                        <?php if ($it_security_button_text != '') { ?>
                                            <a href="<?php echo esc_url($it_security_button_link_banner); ?>" class="button">
                                                <?php echo esc_html($it_security_button_text); ?>
                                                <span class="screen-reader-text"><?php echo esc_html($it_security_button_text); ?></span>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="bnr-btn-box1 position-absolute"></div>
                                <div class="bnr-btn-box2 position-absolute"></div>
                                <div class="bnr-btn-box3 position-absolute"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
                wp_reset_postdata();
            ?>
            <div class="banner-circle1 position-absolute">
                <div class="banner-inner-circle1"></div>
            </div>
            <div class="banner-circle2 position-absolute">
                <div class="banner-inner-circle2"></div>
            </div>
            <div class="banner-circle3 position-absolute">
                <div class="banner-inner-circle3"></div>
            </div>
            <div class="banner-circle4 position-absolute">
                <div class="banner-inner-circle4"></div>
            </div>
            <div class="banner-circle5 position-absolute">
                <div class="banner-inner-circle5"></div>
            </div>
            <div class="banner-circle6 position-absolute">
                <div class="banner-inner-circle6"></div>
            </div>
        </div>
    <?php } ?>

    <!-- Case Section -->
    <?php
        $it_security_hide_casebox = get_theme_mod('it_security_show_case_section', false);
        $it_security_case_catData = get_theme_mod('it_security_select_case_cat');
        if ($it_security_hide_casebox) { ?>
        <section id="case-section">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-8 offset-lg-7 offset-md-6 col-xl-4 col-lg-5 col-md-6 text-lg-end text-md-end text-center case-heading-box">
                        <?php if (get_theme_mod('it_security_case_study_sec_title') != '') { ?>
                            <h2 class="case-sec-title text-uppercase mb-2"><?php echo esc_html(get_theme_mod('it_security_case_study_sec_title')); ?></h2>
                        <?php } ?>
                        <?php if (get_theme_mod('it_security_case_study_sec_text') != '') { ?>
                            <p class="case-sec-text mb-2"><?php echo esc_html(get_theme_mod('it_security_case_study_sec_text')); ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="owl-carousel">
                <?php
                    $it_security_case_catData = get_theme_mod('it_security_select_case_cat', '0');
                    if ($it_security_case_catData !== '0') :
                    $it_security_page_query = new WP_Query(array(
                        'category_name'  => esc_attr($it_security_case_catData),
                        'posts_per_page' => 6,
                    ));
                    $it_security_counter = 1;
                    while ($it_security_page_query->have_posts()) : $it_security_page_query->the_post(); 
                ?>
                <div class="case-content pb-5 mb-5">
                    <div class="imagebox mb-2">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('full', array('class' => 'post-image'));
                        } else { ?>
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/post-img.png" alt="<?php echo esc_attr('slider', 'it-security'); ?>" class="post-image" />
                        <?php } ?>
                    </div>
                    <div class="text-content position-relative">
                        <div class="text-inner-content">
                            <p class="post-number mb-1"><?php echo esc_html(sprintf('%02d', $it_security_counter)); ?></p>
                            <h3 class="case-title text-uppercase mb-1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php
                            $it_security_trimexcerpt  = get_the_excerpt();
                            $it_security_shortexcerpt = wp_trim_words($it_security_trimexcerpt, $it_security_num_words = 15);
                            echo '<p class="case-desc mb-3">' . esc_html($it_security_shortexcerpt) . '</p>';
                            ?>
                            <div class="case-main-btn position-absolute">
                                <div class="casebtn position-relative text-center">
                                    <div class="case-inner-btn p-2">
                                        <?php 
                                        $it_security_button_text = get_theme_mod('it_security_button_text', 'Explore More');
                                        $it_security_button_link_case = get_theme_mod('it_security_button_link_case', '');

                                        if (empty($it_security_button_link_case)) {
                                            $it_security_button_link_case = esc_url(get_permalink());
                                        }

                                        if ($it_security_button_text || !empty($it_security_button_link_case)) {
                                            if (get_theme_mod('it_security_button_text', 'Explore More') != '') { ?>
                                                <a href="<?php echo esc_url($it_security_button_link_case); ?>" class="post-btn text-capitalize">
                                                    <?php echo esc_html($it_security_button_text); ?>
                                                    <span class="screen-reader-text"><?php echo esc_html($it_security_button_text); ?></span>
                                                </a>
                                            <?php }
                                        } ?>
                                    </div>
                                    <div class="btn-box1 position-absolute"></div>
                                    <div class="btn-box2 position-absolute"></div>
                                    <div class="btn-box3 position-absolute"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $it_security_counter++;
                    endwhile;
                    wp_reset_postdata();
                    endif;
                ?>
            </div>
        </section>
    <?php } ?>
</div>
<?php get_footer(); ?>