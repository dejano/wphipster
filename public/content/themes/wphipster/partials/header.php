<?php
$options = get_option(WPHIPSTER_OPTIONS_NAME);

$logo_image = $options['logo_image'];
$logo_text = $options['logo_text'];
$header_text = $logo_text;
$preloader_class = '';
if ($options['page_loading_effect'] == 'header') {
    $preloader_class .= 'nav-bar--loader'; // replace with header--loader
}

if (is_single()) {
    global $post;
    $header_text = $post->post_title;
}

$logo_image = $logo_image ? $logo_image : '';

$header_class = $options['sticky_header'] ? 'header--sticky' : '';
$logo_class = $options['sticky_header'] ? 'logo--hidden' : '';
?>
<header class="header <?php echo $header_class; ?>">
    <nav class="nav-bar nav-bar--short nav-bar--has-shadow-element">
        <a href="#" data-activates="mobile-nav" class="button-collapse button--mobile-menu right"><i
                class="material-icons">menu</i></a>

        <div class="logo <?php echo $logo_class; ?> left">
            <a href="<?php echo home_url(); ?>">
                <?php if ($logo_image) : ?>
                    <img class="logo--image" src="<?php echo $logo_image; ?>" alt="">
                <?php endif; ?>

                <span class="logo--text"><?php echo $logo_text; ?></span>
            </a>
        </div>
        <?php
        wp_nav_menu([
            'theme_location' => 'main_menu',
            'container' => false,
            'menu_class' => 'right hide-on-med-and-down menu--main',
            'walker' => new Menu_Walker()
        ]);
        ?>
        <!--        <ul class="right hide-on-med-and-down">-->
        <!--            <li><a href="#"><i class="material-icons search-icon">search</i></a></li>-->
        <!--        </ul>-->
    </nav>
    <!--   nav-bar--short Close-->
    <div class="nav-bar__nav-shadow"></div>

    <div class="nav-bar nav-bar--long <?php echo $preloader_class; ?>">
        <div class="nav-bar__title"><?php echo $header_text; ?> <span class="slide-in"></span> <span
                class="char--blinking-cursor">|</span></div>
    </div>
    <!-- nav-bar--long Close -->

</header>
<!-- Header close -->