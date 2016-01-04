<?php
$options = get_option(WPHIPSTER_OPTIONS_NAME);
$main_content_col_len = 12;
if ($options['sidebar'] != 0) {
    $main_content_col_len = 8;
}

if (have_posts()) : ?>

    <?php if (is_home() && !is_front_page()) : ?>
        <header>
            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
        </header>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <?php if ($options['sidebar'] == 1): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
            <div id="blog-posts" class="col l<?php echo $main_content_col_len; ?> m12 s12 blog-posts">
                <div class="timeline-string"></div>
                <?php

                // Start the loop.
                while (have_posts()) : the_post();
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    $template_prefix = '';
                    if (is_single()) :
                        $template_prefix = '/single';
                    endif;

                    get_template_part('partials/content' . $template_prefix, get_post_format());


                    // End the loop.
                endwhile;
                get_wp_hipster_theme()->pagination($wp_query->max_num_pages);
                // Previous/next page navigation.
                //                the_posts_pagination(array(
                //                    'prev_text' => __('Previous page', 'twentyfifteen'),
                //                    'next_text' => __('Next page', 'twentyfifteen'),
                //                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyfifteen') . ' </span>',
                //                ));
                ?>
            </div>
            <?php if ($options['sidebar'] == 2): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
// If no content, include the "No posts found" template.
else :
    get_template_part('content', 'none');

endif;
?>