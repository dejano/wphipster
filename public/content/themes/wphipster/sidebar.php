<?php if (is_active_sidebar('sidebar-widget')) : ?>
    <div id="sidebar-left" class="col l4 m12 s12 sidebar-wrapper">
        <aside class="sidebar z-depth-1">
            <?php dynamic_sidebar('sidebar-widget'); ?>
        </aside>
    </div>
<?php endif; ?>