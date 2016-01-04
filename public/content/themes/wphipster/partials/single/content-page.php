<?php
$options = get_option(WPHIPSTER_OPTIONS_NAME);
$main_content_col_len = 12;
if ($options['sidebar'] != 0) {
    $main_content_col_len = 8;
}

?>
    <article id="post-<?php the_ID(); ?>" <?php post_class("col s12 post--single"); ?>>
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
                    <div id="sidebar-left" class="col l4 m12 s12 sidebar-wrapper">
                        <?php get_sidebar(); ?>
                    </div>
                <?php endif; ?>
                <div class="col s12 m<?php echo $main_content_col_len; ?> content">
                    <?php the_time('F j, Y') ?>
                    <?php if (get_wp_hipster_theme()->categories_as_string()): ?>
                        <span class="cat-links">
                            Posted in <?php echo get_wp_hipster_theme()->categories_as_string(); ?>
                        </span>
                    <?php endif; ?>
                    by <a
                        href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>


                    <p>
                        <?php the_content(); ?>
                    </p>
                    <?php if (has_tag()): ?>
                        <p class="tags">
                            <?php get_wp_hipster_theme()->tags_with_hash_tag(); ?>
                        </p>
                    <?php endif; ?>

                    <?php comments_template(); ?>
                </div>
                <?php if ($options['sidebar'] == 2): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>
            </div>
        </div>

    </article>
    <div class="social-share">
        <div class="fixed-action-btn horizontal social-share-btn">
            <a class="btn-floating btn-large purple">
                <i class="material-icons">share</i>
            </a>
            <ul>
                <li><a class="btn-floating red darken-1"><i class="fa fa-google-plus"></i></a></li>
                <li><a class="btn-floating blue lighten-2"><i class="fa fa-twitter"></i></a></li>
                <li><a class="btn-floating blue darken-1"><i class="fa fa-facebook"></i></a></li>
            </ul>
        </div>
    </div>

<?php get_template_part('partials/post', 'related'); ?>
<?php get_template_part('partials/post', 'nav'); ?>