<?php
get_header(); ?>

    <header>
        <?php get_template_part('partials/header'); ?>
    </header>
    <div id="primary" class="content-area">
        <main id="section" role="main">
            <?php while (have_posts()) : the_post(); ?>
                <?php
                get_template_part('partials/single/content', get_post_format());
                ?>
            <?php endwhile; ?>
        </main>
        <!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer(); ?>