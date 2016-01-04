<div class="<?php echo $card_classes; ?>">
    <div class="card__content">
        <a href="<?php the_permalink(); ?>">
            <h2 class="title title--card"><?php the_title(); ?></h2>
        </a>
        <?php the_excerpt(); ?>
    </div>
    <footer class="card__footer">
        <a href="<?php the_permalink(); ?>"
           class="btn btn-floating btn-large waves-effect waves-light right hide-on-large">
            <i class="material-icons">chevron_right</i>
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