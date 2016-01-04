<?php

if (has_post_thumbnail()) {
    $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full-width');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <span class="event-date">
                    <?php the_time('F j, Y') ?>
                </span>

    <div class="card ">
        <?php if (has_post_thumbnail()) : ?>
            <div class="image-wrapper">
                <div class="card-image full-width waves-effect waves-light wave-link">
                    <a href="<?php the_permalink(); ?>">
                        <img class="responsive-img" src="<?php echo $img[0]; ?>"
                             alt="<?php get_wp_hipster_theme()->get_image_alt(get_post_thumbnail_id()); ?>"/>
                    </a>
                    <span class="v-lines"></span>
                    <a class="wave-href" href="<?php the_permalink(); ?>">
                        <h2 class="card-title"><?php the_title(); ?></h2>
                    </a>

                    <div class="title-background"></div>
                </div>
                        <span
                            class="btn-floating btn-large waves-effect waves-light right purple hide-on-large z-3 wave-link">
                            <i class="material-icons">chevron_right</i>
                        </span>
            </div>
        <?php endif; ?>
        <div class="card-content">
            <?php if (!has_post_thumbnail()) : ?>
                <a class="wave-href" href="<?php the_permalink(); ?>">
                    <h2 class="card-title"><?php the_title(); ?></h2>
                </a>
            <?php endif; ?>
            <p><?php the_excerpt(); ?></p>
        </div>
        <footer class="card-meta grey lighten-5">
            <?php if (!has_post_thumbnail()) : ?>
                <a class="btn-floating btn-large waves-effect waves-light right purple hide-on-large no-image wave-link">
                    <i class="material-icons">chevron_right</i>
                </a>
            <?php endif; ?>

            <?php if (get_wp_hipster_theme()->categories_as_string()): ?>
                <span class="cat-links">
                                Posted in <?php echo get_wp_hipster_theme()->categories_as_string(); ?>
                            </span>
            <?php endif; ?>
            by <a
                href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>

        </footer>
    </div>
</article>

<!--        {% if options.sidebar == 2 %}-->
<!--        <div id="sidebar-right" class="col m4 s12 sidebar-wrapper">-->
<!--            {% include "base/sidebar.twig" %}-->
<!--        </div>-->
<!--        {% endif %}-->
