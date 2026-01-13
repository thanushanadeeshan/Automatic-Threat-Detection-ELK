<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package IT Security
 */
?>

<div id="sidebar">    
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
        <aside role="complementary" aria-label="<?php esc_attr_e( 'sidebar1', 'it-security' ); ?>" id="search" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Search', 'it-security' ); ?></h3>
            <?php get_search_form(); ?>
        </aside>
        <aside role="complementary" aria-label="<?php esc_attr_e( 'sidebar2', 'it-security' ); ?>" id="categories" class="widget"> 
            <h3 class="widget-title"><?php esc_html_e( 'Categories', 'it-security' ); ?></h3>          
            <ul>
                <?php wp_list_categories('title_li=');  ?>
            </ul>
        </aside>
        <aside role="complementary" aria-label="<?php esc_attr_e( 'sidebar3', 'it-security' ); ?>" id="recent-posts" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'it-security' ); ?></h3>
            <ul>
                <?php
                $it_security_recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                ));
                foreach ($it_security_recent_posts as $it_security_post) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_permalink($it_security_post['ID'])); ?>">
                            <?php echo esc_html($it_security_post['post_title']); ?>
                        </a>
                    </li>
                <?php endforeach; wp_reset_postdata(); ?>
            </ul>
        </aside>
        <aside role="complementary" aria-label="<?php esc_attr_e('sidebar4', 'it-security'); ?>" id="archives" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Archives', 'it-security' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>
        <aside role="complementary" aria-label="<?php esc_attr_e('sidebar5', 'it-security'); ?>" id="meta" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Meta', 'it-security' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>
    <?php endif; // end sidebar widget area ?>  
</div>