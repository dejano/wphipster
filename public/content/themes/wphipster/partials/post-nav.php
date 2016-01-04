<?php
$prev = get_previous_post();
$next = get_next_post();
$next_class = $prev ? '' : 'push-l6';
?>
<?php if ($next || $prev): ?>
    <div class="row post-nav z-depth-1">
        <?php if ($prev) : ?>
            <div class="col l6 m12 s12 post-nav--prev left-align waves-effect waves-light wave-link">

                <span class="post-nav__caption">Previous</span>
                <span class="title title--post-nav"> <a class="white-text wave-href"
                                        href="<?php the_permalink($prev->ID); ?>"><?php echo $prev->post_title; ?></a></span>
                <i class="material-icons hide-on-med-and-down">chevron_left</i>

            </div>
        <?php endif; ?>
        <?php if ($next) : ?>
            <div
                class="col l6 m12 s12 <?php echo $next_class; ?> post-nav--next right-align waves-effect waves-light wave-link">

                <span class="post-nav__caption">Next</span>
                <span class="title title--post-nav"> <a class="white-text wave-href"
                                        href="<?php the_permalink($next->ID); ?>"><?php echo $next->post_title; ?></a></span>
                <i class="material-icons hide-on-med-and-down">chevron_right</i>

            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>