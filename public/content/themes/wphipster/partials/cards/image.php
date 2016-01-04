<?php
$options = get_option(WPHIPSTER_OPTIONS_NAME);
if ($options['card_animation'] == 'awesomeness') {
    $animation_classes = 'card__image--lines card__image--rectangle card__image--zoom';
} else if ($options['card_animation'] == 'zoom') {
    $animation_classes = 'card__image--zoom';
}
?>
<div class="<?php echo $card_classes; ?>">
    <div
        class="card__image <?php echo $animation_classes; ?> waves-effect waves-light">
        <a href="<?php the_permalink(); ?>">
            <img class="responsive-img" src="<?php echo $img[0]; ?>"
                 alt="<?php get_wp_hipster_theme()->get_image_alt(get_post_thumbnail_id()); ?>"/>

            <span class="pseudo-v-lines"></span>
            <span class="pseudo-v-lines"></span>

            <h2 class="title title--card title--zoom"><?php the_title(); ?></h2>

            <div class="pseudo-rectangle"></div>
        </a>
    </div>
    <a href="<?php the_permalink(); ?>"
       class="btn btn-floating btn-large waves-effect waves-light right hide-on-large z-3">
        <i class="material-icons">chevron_right</i>
    </a>

    <div class="card__content">
        <?php the_excerpt(); ?>
    </div>
    <footer class="card__footer">
        <?php if (get_wp_hipster_theme()->categories_as_string()): ?>
            <span class="links-list links-list--category">
                                Posted in <?php echo get_wp_hipster_theme()->categories_as_string(); ?>
                            </span>
        <?php endif; ?>
        by <a
            href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>
    </footer>
</div>