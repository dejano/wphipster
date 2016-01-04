<?php

namespace wp_hipster\core;

/**
 * Class WP_Hipster_Builder
 * @package Whipster\core
 */
class WP_Hipster_Builder implements Builder
{

    // TODO: default options file
    // TODO: move widgets and sidebars to another builder (need options at that point.)

    /**
     * @var array Supported post formats.
     */
    private $post_formats;

    /**
     * @var string Source of stylesheet for editor.
     */
    private $editor_style_source;

    /**
     * @var double Minimal Wordpress version required.
     */
    private $min_wp_version;

    /**
     * @var string Text domain
     */
    private $text_domain;

    /**
     * @var array Widget settings array.
     */
    private $widgets;

    /**
     * @var array Sidebar settings array.
     */
    private $sidebars;

    /**
     * @var boolean Include bootstrap assets.
     */
    private $with_bootstrap;

    /**
     * @var string Path to assets. Default value is '/static'.
     */
    private $assets_path = '/static';

    /**
     * @var boolean Include Font Awesome assets.
     */
    private $with_font_awesome;

    /**
     * @var string Path to options config file.
     */
    private $options_file_path = '/config/options.php';

    /**
     * @var string Path to sidebars config file.
     */
    private $sidebars_file_path = '/config/sidebars.php';

    /**
     * @var string Path to menus config file.
     */
    private $menus_file_path = '/config/menus.php';

    /**
     * @var string Full class name of theme class.
     */
    private $theme_class;

    /**
     * Creates instance with default values.
     * Default values:
     * min_version = 4.1
     * post_formats = ['image', 'video', 'gallery', 'aside', 'link']
     * text_domain = 'wp_hipster'
     * assets_path = '/static';
     * widgets = ['WP_Hipster\widget\WhipsterSocialsWidget']
     *
     * @return WP_Hipster_Builder
     */
    public static function defaultOptions()
    {
        $widgets = ['wp_hipster\widget\WP_Hipster_Socials_Widget'];
        $builder = new WP_Hipster_Builder();
        return $builder
            ->set_min_wp_version('4.1')
            ->set_post_formats(['image', 'video', 'gallery', 'aside', 'link'])
            ->set_text_domain('whipster')
            ->set_assets_path('/static')
            ->set_widgets($widgets);
    }

    /**
     * Creates instance of WP_Hipster object from $this.
     * @return WP_Hipster
     * @throws \Exception
     */
    function build()
    {
        return WP_Hipster::getInstance($this);
    }

    /**
     * @return array
     */
    public function get_post_formats()
    {
        return $this->post_formats;
    }

    /**
     * @param array $post_formats
     * @return WP_Hipster_Builder
     */
    public function set_post_formats($post_formats)
    {
        $this->post_formats = $post_formats;
        return $this;
    }

    /**
     * @return string
     */
    public function get_editor_style_source()
    {
        return $this->editor_style_source;
    }

    /**
     * @param string $editor_style_source
     * @return WP_Hipster_Builder
     */
    public function set_editor_style_source($editor_style_source)
    {
        $this->editor_style_source = $editor_style_source;
        return $this;
    }

    /**
     * @return float
     */
    public function get_min_wp_version()
    {
        return $this->min_wp_version;
    }

    /**
     * @param float $min_wp_version
     * @return WP_Hipster_Builder
     */
    public function set_min_wp_version($min_wp_version)
    {
        $this->min_wp_version = $min_wp_version;
        return $this;
    }

    /**
     * @return string
     */
    public function get_text_domain()
    {
        return $this->text_domain;
    }

    /**
     * @param string $text_domain
     * @return WP_Hipster_Builder
     */
    public function set_text_domain($text_domain)
    {
        $this->text_domain = $text_domain;
        return $this;
    }

    /**
     * @return array
     */
    public function get_widgets()
    {
        return $this->widgets;
    }

    /**
     * @param array $widgets
     * @return WP_Hipster_Builder
     */
    public function set_widgets($widgets)
    {
        $this->widgets = $widgets;
        return $this;
    }

    /**
     * @return array
     */
    public function get_sidebars()
    {
        return $this->sidebars;
    }

    /**
     * @param array $sidebars
     * @return WP_Hipster_Builder
     */
    public function set_sidebars($sidebars)
    {
        $this->sidebars = $sidebars;
        return $this;
    }

    /**
     * @return boolean
     */
    public function is_with_bootstrap()
    {
        return $this->with_bootstrap;
    }

    /**
     * @param boolean $with_bootstrap
     * @return WP_Hipster_Builder
     */
    public function set_with_bootstrap($with_bootstrap)
    {
        $this->with_bootstrap = $with_bootstrap;
        return $this;
    }

    /**
     * @return string
     */
    public function get_assets_path()
    {
        return $this->assets_path;
    }

    /**
     * @param string $assets_path
     * @return WP_Hipster_Builder
     */
    public function set_assets_path($assets_path)
    {
        $this->assets_path = $assets_path;
        return $this;
    }

    /**
     * @return boolean
     */
    public function is_with_font_awesome()
    {
        return $this->with_font_awesome;
    }

    /**
     * @param boolean $with_font_awesome
     * @return WP_Hipster_Builder
     */
    public function set_with_font_awesome($with_font_awesome)
    {
        $this->with_font_awesome = $with_font_awesome;
        return $this;
    }

    /**
     * @return string
     */
    public function get_options_file_path()
    {
        return $this->options_file_path;
    }

    /**
     * @param string $options_file_path
     * @return WP_Hipster_Builder
     */
    public function set_options_file_path($options_file_path)
    {
        $this->options_file_path = $options_file_path;
        return $this;
    }

    /**
     * @return string
     */
    public function get_sidebars_file_path()
    {
        return $this->sidebars_file_path;
    }

    /**
     * @param string $sidebars_file_path
     * @return WP_Hipster_Builder
     */
    public function set_sidebars_file_path($sidebars_file_path)
    {
        $this->sidebars_file_path = $sidebars_file_path;
        return $this;
    }

    /**
     * @return string
     */
    public function get_menus_file_path()
    {
        return $this->menus_file_path;
    }

    /**
     * @param string $menus_file_path
     * @return WP_Hipster_Builder
     */
    public function set_menus_file_path($menus_file_path)
    {
        $this->menus_file_path = $menus_file_path;
        return $this;
    }

    /**
     * @return string
     */
    public function get_theme_class()
    {
        return $this->theme_class;
    }

    /**
     * @param string $theme_class
     * @return WP_Hipster_Builder
     */
    public function set_theme_class($theme_class)
    {
        $this->theme_class = $theme_class;
        return $this;
    }


}