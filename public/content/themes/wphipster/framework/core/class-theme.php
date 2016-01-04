<?php

namespace wp_hipster\core;

/**
 * Class Theme
 * @package WPhipster\core
 */
abstract class Theme
{

    protected $dir;
    protected $uri;
    /**
     * @var string
     */
    protected $assets_dir;

    /**
     * @var string
     */
    protected $assets_uri;

    /**
     * Theme constructor.
     * @param $builder WP_Hipster_Builder
     */
    public function __construct($builder)
    {
        $this->dir = get_stylesheet_directory();
        $this->uri = get_stylesheet_directory_uri();
        $this->assets_dir = $this->dir . $builder->get_assets_path();
        $this->assets_uri = $this->uri . $builder->get_assets_path();
    }

    /**
     * @return string
     */
    public function get_dir()
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     */
    public function set_dir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function get_uri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function set_uri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function get_assets_dir()
    {
        return $this->assets_dir;
    }

    /**
     * @param string $assets_dir
     */
    public function set_assets_dir($assets_dir)
    {
        $this->assets_dir = $assets_dir;
    }

    /**
     * @return string
     */
    public function get_assets_uri()
    {
        return $this->assets_uri;
    }

    /**
     * @param string $assets_uri
     */
    public function set_assets_uri($assets_uri)
    {
        $this->assets_uri = $assets_uri;
    }


}