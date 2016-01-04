<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */

$options = get_option(WPHIPSTER_OPTIONS_NAME);
$footer_columns = $options['footer_columns'];
$footer_columns_len = 12 / $footer_columns;

?>
<footer id="footer" class="page-footer">
    <?php if ($options['large_footer']): ?>
        <div class="container">
            <div class="row">

                <?php for ($i = 1; $i <= $footer_columns; $i++) : ?>
                    <div class="footer-col col l<?php echo $footer_columns_len; ?>">
                        <?php dynamic_sidebar('footer-widget-' . $i); ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($options['lower_footer']): ?>
        <div class="footer-copyright">
            <div class="container">
                <span
                    class="copyright right"><?php echo get_option(WPHIPSTER_OPTIONS_NAME)['footer_copyright']; ?></span>
            </div>
        </div>
    <?php endif; ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>