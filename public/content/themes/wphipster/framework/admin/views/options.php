<div class="wrap oxygenna-options-page">
    <div class="icon32">
        <img src="" alt="Oxygenna logo">
    </div>
    <h2><?php echo get_admin_page_title(); ?></h2>
    <?php settings_errors(); ?>

    <div id="ajax-errors-here"></div>
    <form method="post" action="options.php">
        <?php do_settings_sections($page); ?>
        <?php settings_fields(WPHIPSTER_OPTIONS_GROUP); ?>
        <div class="submit-footer">
            <?php submit_button(__('Save Changes', 'wp_hipster'), 'primary', 'save_changes'); ?>
            <?php submit_button(__('Restore Defaults', 'wp_hipster'), 'secondary', 'reset_options'); ?>
        </div>
    </form>
</div>