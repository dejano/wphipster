<?php
$related = [
    'category__in' => wp_get_post_categories($post->ID),
    'posts_per_page' => 2,
    'post__not_in' => [$post->ID]
];
$related_posts = new WP_Query($related);

if ($related_posts->have_posts()) :?>
    <div class="related">
        <div class="related-wrapper">
            <div class="row">
                <span class="title--section-related title--section col s12">Related Posts</span>
                <?php while ($related_posts->have_posts()) :
                    $related_posts->the_post();
                    if (has_post_thumbnail()) {
                        $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                        $style = "background: url($img[0]) no-repeat center center ;";
                    }
                    ?>
                    <div class="col s12 m12 l6 ">
                        <div
                            class="card card--related animation--light hoverable waves-effect waves-light wave-link" <?php if (has_post_thumbnail()) : ?>
                            style="<?php echo $style; ?>" <?php endif; ?>>
                            <div class="card__content">
                                <a class="wave-href" href="<?php the_permalink(); ?>">
                                    <div class="title title--related"><?php the_title(); ?></div>
                                </a>

                                <div class="related__description">Lorem ipsum dolor sit amet, consectetur.</div>
                            </div>
                            <footer class="card__footer related__meta">
                                Posted in <?php echo get_wp_hipster_theme()->categories_as_string(); ?> by<a
                                    href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </footer>
                        </div>
                    </div>

                <?php endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>