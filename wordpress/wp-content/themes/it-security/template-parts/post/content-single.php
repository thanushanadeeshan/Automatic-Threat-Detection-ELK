<?php
/**
 * @package IT Security
 */
?>

<?php
    $it_security_post_date = esc_html(get_the_date());
    
    $it_security_author_name = esc_html(get_the_author());

    $it_security_single_post_show_date     = get_theme_mod('it_security_single_post_date', true);
    $it_security_single_post_show_comments = get_theme_mod('it_security_single_post_comment', true);
    $it_security_single_post_show_author   = get_theme_mod('it_security_single_post_author', true);
    $it_security_single_post_show_time     = get_theme_mod('it_security_single_post_time', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
    
    <?php 
    $it_security_designation = get_post_meta($post->ID, 'it_security_designation', true);
    
    if ($it_security_designation) : ?>
        <p class="serv-content"><?php echo esc_html($it_security_designation); ?></p>
    <?php endif; ?>
    <div class="social-icon text-start">
        <?php
        $it_security_facebook_link = get_post_meta($post->ID, 'it_security_facebook_link', true);
        $it_security_twitter_link = get_post_meta($post->ID, 'it_security_twitter_link', true);
        $it_security_telegram_link = get_post_meta($post->ID, 'it_security_telegram_link', true);

        if ($it_security_facebook_link || $it_security_twitter_link || $it_security_telegram_link) :
        ?>
            <div class="meta-fields text-start">
                <?php if ($it_security_facebook_link) : ?>
                    <a href="<?php echo esc_url($it_security_facebook_link); ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                <?php endif; ?>

                <?php if ($it_security_twitter_link) : ?>
                    <a href="<?php echo esc_url($it_security_twitter_link); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                <?php endif; ?>

                <?php if ($it_security_telegram_link) : ?>
                    <a href="<?php echo esc_url($it_security_telegram_link); ?>" target="_blank"><i class="fab fa-telegram"></i></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if (has_post_thumbnail() ){ ?>
        <div class="post-thumb">
           <?php the_post_thumbnail(); ?>
        </div>
    <?php } ?>

    <?php if ('post' == get_post_type()) : ?>
        <?php if ( $it_security_single_post_show_date || $it_security_single_post_show_comments || $it_security_single_post_show_author || $it_security_single_post_show_time ) : ?>
            <div class="postmeta">
                <?php if ($it_security_single_post_show_date) : ?>
                <div class="post-date">
                    <i class="fas fa-calendar-alt"></i> &nbsp;<?php echo esc_html($it_security_post_date); ?>
                </div>
                <?php endif; ?>
                <?php if ($it_security_single_post_show_comments) : ?>
                <div class="post-comment">&nbsp; &nbsp;
                    <span><?php echo esc_html(get_theme_mod('it_security_single_post_metabox_seperator', '|'));?></span>
                    <i class="fa fa-comment"></i> &nbsp; <?php comments_number(); ?>
                </div>
                <?php endif; ?>
                <?php if ($it_security_single_post_show_author) : ?>
                    <div class="post-author">&nbsp; &nbsp;
                        <span><?php echo esc_html(get_theme_mod('it_security_single_post_metabox_seperator', '|'));?></span>
                        <i class="fas fa-user"></i> &nbsp; <?php echo esc_html($it_security_author_name); ?>
                    </div>
                <?php endif; ?>
                <?php if ($it_security_single_post_show_time) : ?>
                    <div class="post-time">&nbsp; &nbsp;
                        <span><?php echo esc_html(get_theme_mod('it_security_single_post_metabox_seperator', '|'));?></span>
                        <i class="fas fa-clock"></i> &nbsp; <?php echo get_the_time(); ?>
                    </div>
                <?php endif; ?>
            </div> 
        <?php endif; ?>
    <?php endif; ?>
    <div class="entry-content">
        <?php the_content(); ?>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'it-security' ),
                'after'  => '</div>',
            ) );
        ?>
        <div class="tags"><?php the_tags(); ?></div>
    </div>
    <footer class="entry-meta">
        <?php edit_post_link( __( 'Edit', 'it-security' ), '<span class="edit-link">', '</span>' ); ?>
    </footer>
</article>