<?php
$card_classes = 'card card--post';
$card_type = 'normal';
if (has_post_thumbnail()) {
    $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full-width');
    $card_classes .= ' card--with-image';
    $card_type = 'image';
}

if (is_sticky()) {
    $card_classes .= ' card--sticky';
    $card_type = 'sticky';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(['post']); ?>>
    <span class="event-date">
        <?php the_time('F j, Y') ?>
    </span>

    <?php switch ($card_type):
        case 'normal': ?>
            <?php include dirname(__FILE__) . '/cards/basic.php'; ?>
            <?php break; ?>
        <?php case 'image': ?>
            <?php include dirname(__FILE__) . '/cards/image.php'; ?>
            <?php break; ?>
        <?php case 'sticky': ?>
            <?php include dirname(__FILE__) . '/cards/sticky.php'; ?>
            <?php break; ?>
        <?php endswitch; ?>
</article>
