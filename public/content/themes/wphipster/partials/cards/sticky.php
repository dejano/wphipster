<?php

$options = get_option(WPHIPSTER_OPTIONS_NAME);
$color = get_wp_hipster_theme()->get_color($options['primary_color'], $options['lightness'] . '-3');
if (isset($img[0])) {
    $css = "style='background: linear-gradient(rgba(" . $color . ", .9),rgba(" . $color . ", .9)), url({$img[0]});'";
} else {
    $css = "style='background: linear-gradient(rgba(" . $color . ", 1), rgba(" . $color . ", 1));'";
}

if (isset($options['3d_card']) && $options['3d_card']) {
    $card_classes .= ' card--3d';
}


?>
<div class="card__3d-wrapper">
    <div class="<?php echo $card_classes; ?>" <?php echo $css; ?>>
        <div class="card__content">
            <a href="<?php the_permalink(); ?>">
                <h2 class="title title--card"><?php the_title(); ?></h2>
            </a>
            <?php the_excerpt(); ?>
        </div>
        <footer class="card__footer">
            <a href="<?php the_permalink(); ?>" class="card__arrow right">
                <i class="right material-icons">chevron_right</i>
            </a>

            <?php if (get_wp_hipster_theme()->categories_as_string()): ?>
                <span class="links-list links-list--category">
                                Posted in <?php echo get_wp_hipster_theme()->categories_as_string(); ?>
                            </span>
            <?php endif; ?>
            by <a
                href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>

        </footer>
    </div>
</div>