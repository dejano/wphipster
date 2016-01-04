<?php
$options = get_option(WPHIPSTER_OPTIONS_NAME);
$main_content_col_len = 12;
if ($options['sidebar'] != 0) {
    $main_content_col_len = 8;
}

$post_format = get_post_format();
$post_classes = '';
if ($post_format === 'video' || $post_format === 'gallery') {
    $post_classes .= 'post--bg post--corners';
}

if ($post_format === 'image') {
    $post_classes .= 'post--bg';
}

?>
    <article id="post-<?php the_ID(); ?>" <?php post_class("col s12 post--single " . $post_classes); ?>>
        <?php if (has_post_thumbnail()): ?>
            <div class="parallax-container">
                <?php
                $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                ?>
                <div class="parallax"><img align="middle" src="<?php echo $img[0]; ?>"
                                           alt="{{ post.thumbnail.alt() }}"></div>
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <?php if ($options['sidebar'] == 1): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>
                <div class="col s12 l<?php echo $main_content_col_len; ?> post__content-wrapper">
                    <div class="post__content">
                        <?php the_time('F j, Y') ?>
                        <?php if (get_wp_hipster_theme()->categories_as_string()): ?>
                            <span class="cat-links">
                            Posted in <?php echo get_wp_hipster_theme()->categories_as_string(); ?>
                        </span>
                        <?php endif; ?>
                        by <a
                            href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>


                        <?php the_content(); ?>

                        <?php if (has_tag()): ?>
                            <p class="post__tags">
                                <?php get_wp_hipster_theme()->tags_with_hash_tag(); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <section>
                        <?php comments_template(); ?>
                    </section>
                </div>
                <?php if ($options['sidebar'] == 2): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>
            </div>
        </div>

    </article>

<?php get_template_part('partials/post', 'share'); ?>
<?php get_template_part('partials/post', 'related'); ?>
<?php get_template_part('partials/post', 'nav'); ?>