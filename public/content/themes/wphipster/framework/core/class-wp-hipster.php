<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/10/15
 * Time: 6:41 AM
 */

namespace wp_hipster\core;


use Exception;
use wp_hipster\admin\WP_Hipster_Admin;
use wp_hipster\sidebar\WP_Hipster_Sidebar_Factory;

class WP_Hipster
{
    /**
     * @var WP_Hipster The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * @var WP_Hipster_Builder
     */
    private $builder;

    /**
     * @var Theme
     */
    private $theme;

    /**
     * @var WP_Hipster_Admin
     */
    private $admin;

    /**
     * @var array IDs of registered sidebars
     */
    private $sidebar_ids;

    /**
     * @var string Path to sidebars settings file
     */
    private $sidebar_file_path;

    /**
     * @var array Content of sidebars settings file
     */
    private $sidebar_settings;

    /**
     * @var string Path to menus settings file
     */
    private $menus_file_path;

    /**
     * @var array Content of menus settings file
     */
    private $menu_settings;

    /**
     * @var string Path to options settings file
     */
    private $options_file_path;

    /**
     * Returns the *Singleton* instance of this class.
     * @param $builder
     * @return WP_Hipster The *Singleton* instance.
     * @throws Exception
     */
    public static function getInstance($builder = null)
    {
        if (null === static::$instance) {
            static::$instance = new static($builder);
            return static::$instance;
        } else if ($builder == static::$instance->builder) {
            return static::$instance;
        } else if (null === $builder && null !== static::$instance) {
            return static::$instance;
        } else {
            throw new Exception("Cannot create an instance of the singleton object due to data inconsistencies.");
        }
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     * @param $builder
     */
    protected
    function __construct($builder)
    {
        $this->builder = $builder;
        $theme_class = $this->builder->get_theme_class();
        $this->theme = new $theme_class($builder);

        $this->sidebar_file_path = $this->builder->get_sidebars_file_path();
        $this->sidebar_settings = require_once($this->theme->get_dir() . $this->sidebar_file_path);
        $this->menus_file_path = $this->builder->get_menus_file_path();
        $this->menu_settings = require_once($this->theme->get_dir() . $this->menus_file_path);
        $this->widgets = $this->builder->get_widgets();
        $this->options_file_path = $this->builder->get_options_file_path();

        if (is_admin()) {
            $this->admin = new WP_Hipster_Admin($this);
        }

        add_action('after_setup_theme', [$this, 'setup_wp']);
        add_action('wp_enqueue_scripts', [$this, 'link_assets']);
        add_action('widgets_init', [$this, 'sidebars_init']);
        $this->register_widgets();

        /**
         * This modifies 'read more' text which should be displayed when using the_excerpt()
         */
        add_filter('excerpt_more', function ($more) {
            return '...';
//            return ' <a class="read-more" href="' . get_permalink(get_the_ID()) . '">' . __('Read More', 'whipster') . '</a>';
        });

        add_filter('excerpt_length', function ($len) {
            return $len;
        }, 999);


    }

    /**
     * @return string
     */
    public function get_options_file_path()
    {
        return $this->options_file_path;
    }

    function sidebars_init()
    {
        if (!function_exists('register_sidebar')) {
            return;
        }

        $this->sidebar_ids = WP_Hipster_Sidebar_Factory::register($this->sidebar_settings);
        do_action('wp_hipster/core/after_sidebars_init');
    }

    function register_widgets()
    {
        foreach ($this->widgets as $widget) {
            add_action('widgets_init', create_function('', 'return register_widget( "' . $widget . '" );'));
        }

        do_action('wp_hipster/core/after_widgets_init');
    }

    public
    function getWidget($id, $callback = null)
    {
        foreach ($this->sidebars->getSections() as $section) {
            foreach ($section->getWidgets() as $widget) {
                if ($widget->getId() == $id) {
                    $result = [];
                    $data = [];
                    ob_start();
                    for ($i = 0; $i < sizeof($widget->getData()); $i++) {
                        dynamic_sidebar($widget->getData()[$i]['id']);
                        $widgetData['content'] = ob_get_contents();

                        if (null !== $callback) {
                            $widgetData['user_data'] = call_user_func_array($callback, [$widgetData]);
//                            $result['user_data'] = $callback($widgetData);
                        }

                        $data[$widget->getData()[$i]['id']] = $widgetData;
                        ob_clean();
                    }
                    ob_end_clean();
                    $result['widgets'] = $data;
                    if (null === $widget->getAssociated()) {
                        return $result;
                    }

                    $data = [];
                    $data[$widget->getAssociated()->getKey()] = $widget->getAssociated()->getValue();
                    $result['data'] = $data;

                    return $result;
                }
            }
        }

        throw new \InvalidArgumentException("Widget with " . $id . " id does not exist.");
    }

    public
    function getWidgetSection($id, $callback = null)
    {
        $result = ['widgets' => [], 'data' => []];
        foreach ($this->sidebars->getSections() as $section) {
            if ($section->getId() == $id) {
                foreach ($section->getWidgets() as $widget) {
                    $widgets = $this->getWidget($widget->getId(), $callback);
                    $result['widgets'] = array_merge($result['widgets'], $widgets['widgets']);
                    if (isset($widgets['data']))
                        $result['data'] = array_merge($result['data'], $widgets['data']);
                }
            }
        }

        return $result;
    }

    function setup_wp()
    {
        load_theme_textdomain($this->builder->get_text_domain());
        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        /**
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        $formats = $this->builder->get_post_formats();
        if (is_array($formats) && !empty($formats)) {
            add_theme_support('post-formats', $formats);
        }

        /**
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
//        add_editor_style([$this->theme->getDir() . $this->builder->getEditorStyleSrc()]);

        /**
         * Register menus
         */
        register_nav_menus($this->menu_settings);
    }

    function link_assets()
    {
        // Adds support for pages with threaded comments
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        if ($this->builder->is_with_bootstrap()) {
            wp_enqueue_style('bootstrap-style', $this->theme->get_uri() . '/bower_components/bootstrap/dist/css/bootstrap.min.css', []);
//            wp_enqueue_script('bootstrap-js', $this->theme->getUri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js', ['jquery'], false, true);
        }

        if ($this->builder->is_with_font_awesome()) {
            wp_enqueue_style('fontawesome-style', $this->theme->get_uri() . '/bower_components/font-awesome/css/font-awesome.min.css', []);
        }

        do_action('wp_hipster/core/after_wp_enqueue_scripts');
    }

    /**
     * @return WP_Hipster_Builder
     */
    public function get_builder()
    {
        return $this->builder;
    }

    /**
     * @return Theme
     */
    public function get_theme()
    {
        return $this->theme;
    }

    /**
     * @return WP_Hipster_Admin
     */
    public function get_admin()
    {
        return $this->admin;
    }

    /**
     * @return array
     */
    public function get_sidebar_ids()
    {
        return $this->sidebar_ids;
    }

    /**
     * @return string
     */
    public function get_sidebar_file_path()
    {
        return $this->sidebar_file_path;
    }

    /**
     * @return array
     */
    public function get_sidebar_settings()
    {
        return $this->sidebar_settings;
    }

    /**
     * @return string
     */
    public function get_menus_file_path()
    {
        return $this->menus_file_path;
    }

    /**
     * @return array
     */
    public function get_menu_settings()
    {
        return $this->menu_settings;
    }


    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private
    function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private
    function __wakeup()
    {
    }

}