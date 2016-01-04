<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 */

get_header(); ?>

<?php get_template_part('partials/header'); ?>
<div id="primary" class="content-area">
    <main id="section" role="main">
        <?php get_template_part('partials/loop'); ?>
    </main>
    <!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
