<?php

if (post_password_required())
    return;
?>
<?php if (have_comments()) : ?>
    <div class="comments row">
        <div class="comments__head col s12 m12">
            <h3 class="title title--comments">
                <?php
                printf(_n('1 comment', '%s comments', get_comments_number(), 'wphipster'), number_format_i18n(get_comments_number()));
                ?>
            </h3>
        </div>
        <!--            <ul class="comments__list col s12 m8 offset-m2 offset-l2">-->
        <ul class="comments__list">
            <?php wp_list_comments(array('walker' => new Comment_Walker(), 'avatar_size' => 80, 'max_depth' => 3)); ?>
            <!--            --><?php //wp_list_comments(); ?>
        </ul>

        <?php
        /*   If there are no comments and comments are closed, let's leave a note.
         * But we only want the note on posts and pages that had comments in the first place.
         */
        if (!comments_open() && get_comments_number()) : ?>
            <br>
            <h3 class="nocomments text-center"><?php _e('Comments are closed.', 'angle-td'); ?></h3>
        <?php endif; ?>

    </div>
<?php endif; ?>
<!--    <div class="comment__form col s12 m8 offset-m2 offset-l2">-->
<div id="js-comment__form" class="comment__form">
    <!--        <div class="card-panel">-->
    <?php get_wp_hipster_theme()->comment_form(); ?>
    <!--        </div>-->
</div>

