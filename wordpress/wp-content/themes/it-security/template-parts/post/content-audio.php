<?php
/**
 * @package IT Security
 */
?>

<?php
    $it_security_post_date = esc_html(get_the_date());
    $it_security_year = esc_html(get_the_date('Y'));
    $it_security_month = esc_html(get_the_date('m'));

    $it_security_author_id = esc_attr(get_the_author_meta('ID'));
    $it_security_author_link = esc_url(get_author_posts_url($it_security_author_id));
    $it_security_author_name = esc_html(get_the_author());
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
    <div class="listarticle">
      <?php
          if ( ! is_single() ) {
          // If not a single post, highlight the audio file.
            if ( ! empty( $audio ) ) {
                foreach ( $audio as $audio_html ) {
                  echo '<div class="entry-audio">';
                  echo $audio_html;
                  echo '</div><!-- .entry-audio -->';
                }
            };
          };
          ?>
        <header class="entry-header">
            <h2 class="single_title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php if ('post' == get_post_type() && ( get_theme_mod('it_security_metafields_date', true) || get_theme_mod('it_security_metafields_comments', true) || get_theme_mod('it_security_metafields_author', true) || get_theme_mod('it_security_metafields_time', true))) : ?>
                <div class="postmeta">
                    <?php if (get_theme_mod('it_security_metafields_date', true)) : ?>
                        <div class="post-date">
                            <a href="<?php echo esc_url(get_month_link($it_security_year, $it_security_month)); ?>">
                           <i class="fas fa-calendar-alt"></i> &nbsp;<?php echo esc_html($it_security_post_date); ?>
                                <span class="screen-reader-text"><?php echo esc_html($it_security_post_date); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>  
                    <?php if (get_theme_mod('it_security_metafields_comments', true)) : ?>  
                        <div class="post-comment">&nbsp; &nbsp;
                            <a href="<?php echo esc_url(get_comments_link()); ?>">
                            <span><?php echo esc_html(get_theme_mod('it_security_metabox_seperator', '|'));?></span><i class="fa fa-comment"></i> &nbsp; <?php comments_number(); ?>
                                <span class="screen-reader-text"><?php comments_number(); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (get_theme_mod('it_security_metafields_author', true)) : ?>
                        <div class="post-author">&nbsp; &nbsp;
                            <a href="<?php echo $it_security_author_link; ?>">
                            <span><?php echo esc_html(get_theme_mod('it_security_metabox_seperator', '|'));?></span><i class="fas fa-user"></i> &nbsp; <?php echo esc_html($it_security_author_name); ?>
                                <span class="screen-reader-text"><?php echo esc_html($it_security_author_name); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (get_theme_mod('it_security_metafields_time', true)) : ?>
                        <div class="post-time">&nbsp; &nbsp;
                            <a href="#">
                            <span><?php echo esc_html(get_theme_mod('it_security_metabox_seperator', '|'));?></span><i class="fas fa-clock"></i> &nbsp; <?php echo esc_html(get_the_time()); ?>
                                <span class="screen-reader-text"><?php echo esc_html(get_the_time()); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </header>
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
            <?php if(get_theme_mod('it_security_blog_post_description_option') == 'Full Content'){ ?>
                <div class="entry-content"><?php
                    $it_security_content = get_the_content(); ?>
                    <p><?php echo wpautop($it_security_content); ?></p>  
                </div>
             <?php }
            if(get_theme_mod('it_security_blog_post_description_option', 'Excerpt Content') == 'Excerpt Content'){ ?>
                <?php if(get_the_excerpt()) { ?>
                    <div class="entry-content"> 
                        <p><?php $it_security_excerpt = get_the_excerpt(); echo esc_html($it_security_excerpt); ?></p>
                    </div>
                <?php }?>
            <?php }?>       
        </div>
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'it-security' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'it-security' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div>
        <?php endif; ?>
        <div class="clear"></div>    
    </div>
</article>

