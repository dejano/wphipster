<?php
// TODO: check http://wphipster.dev/2013/01/02/comments-disabled/ related cards on resize (height issue)
/**
 * Define constants
 */
define('WPHIPSTER_OPTIONS_GROUP', 'whipster_options_group');
define('WPHIPSTER_OPTIONS_NAME', 'whipster_options');
define('WPHIPSTER_THEME_NAME', 'WP Hipster');

if (!isset($content_width)) {
    $content_width = 1280;
}

/**
 * Load framework files
 */
require_once(dirname(__FILE__) . '/framework/autoload.php');

/**
 * Register custom fields.
 */
add_action('wp_hipster/admin/field_factory_init', function ($factory) {
});

/**
 * Load theme files
 */
require_once(dirname(__FILE__) . '/include/autoload.php');

/**
 * Instantiate framework
 */
$wp_hipster_framework_builder = \wp_hipster\core\WP_Hipster_Builder::defaultOptions();
$wp_hipster_framework = $wp_hipster_framework_builder
    ->set_theme_class('\WP_Hipster_Theme')
    ->set_with_font_awesome(true)
    ->build();
$wp_hipster_theme = $wp_hipster_framework->get_theme();

/**
 * @return \WP_Hipster_Theme
 */
function get_wp_hipster_theme()
{
    global $wp_hipster_theme;
    return $wp_hipster_theme;
}

function get_wp_hipster_framework()
{
    global $wp_hipster_framework;
    return $wp_hipster_framework;
}


$labels = array(
    'name' => __('Portfolio Items', 'wphipster'),
    'singular_name' => __('Portfolio Item', 'wphipster'),
    'add_new' => __('Add New', 'wphipster'),
    'add_new_item' => __('Add New Portfolio Item', 'wphipster'),
    'edit_item' => __('Edit Portfolio Item', 'wphipster'),
    'new_item' => __('New Portfolio Item', 'wphipster'),
    'view_item' => __('View Portfolio Item', 'wphipster'),
    'search_items' => __('Search Portfolio Items', 'wphipster'),
    'not_found' => __('No images found', 'wphipster'),
    'not_found_in_trash' => __('No images found in Trash', 'wphipster'),
    'parent_item_colon' => '',
    'menu_name' => __('Portfolio Items', 'wphipster')
);

$args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'has_archive' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'menu_icon' => 'dashicons-portfolio',
    'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
//    'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'page-attributes', 'post-formats'),
    'rewrite' => array('slug' => 'portfolio', 'with_front' => true, 'pages' => true, 'feeds' => false),
);

// create custom post
register_post_type('wphipster_portfolio', $args);


// Register portfolio taxonomy
$labels = array(
    'name' => __('Categories', 'wphipster'),
    'singular_name' => __('Category', 'wphipster'),
    'search_items' => __('Search Categories', 'wphipster'),
    'all_items' => __('All Categories', 'wphipster'),
    'edit_item' => __('Edit Category', 'wphipster'),
    'update_item' => __('Update Category', 'wphipster'),
    'add_new_item' => __('Add New Category', 'wphipster'),
    'new_item_name' => __('New Category Name', 'wphipster')
);

register_taxonomy(
    'wphipster_portfolio_categories',
    'wphipster_portfolio',
    array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
    )
);