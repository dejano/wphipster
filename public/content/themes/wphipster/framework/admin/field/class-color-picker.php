<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 12/8/15
 * Time: 11:46 PM
 */

namespace wp_hipster\admin\field;


class Color_Picker extends Field
{
    /**
     * @param $type
     * @param $id
     * @param $name
     * @param $template
     * @param $value
     */
    public function __construct($type, $id, $name, $template, $value)
    {
        parent::__construct($type, $id, $name, $template, $value);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets()
    {
        wp_register_script('color-picker-js', get_stylesheet_directory_uri() . '/static/js/colorpicker.js', [], false, true);
        wp_enqueue_script('color-picker-js');

        wp_enqueue_style('color-picker-css', get_stylesheet_directory_uri() . '/static/css/colorpicker.css', []);
    }
}