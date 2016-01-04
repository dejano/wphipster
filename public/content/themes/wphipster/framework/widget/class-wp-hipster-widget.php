<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/11/15
 * Time: 8:56 PM
 */

namespace wp_hipster\widget;

use wp_hipster\core\WP_Hipster;

abstract class WP_Hipster_Widget extends \WP_Widget
{
    /**
     * WhipsterWidget constructor.
     *
     * @param string $id_base Optional Base ID for the widget, lowercase and unique. If left empty,
     *                                a portion of the widget's class name will be used Has to be unique.
     * @param string $name Name for the widget displayed on the configuration page.
     * @param array $widget_options Optional. Widget options. See wp_register_sidebar_widget() for information
     *                                on accepted arguments. Default empty array.
     * @param array $control_options Optional. Widget control options. See wp_register_widget_control() for
     *                                information on accepted arguments. Default empty array.
     */
    public function __construct($id_base, $name, $widget_options = array(), $control_options = array())
    {
        $this->templateFile = $widget_options['template'];
        parent::__construct($id_base, $name, $widget_options = array(), $control_options = array());
    }


    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        if (!isset($this->templateFile)) {
            return;
        }
        $framework = WP_Hipster::getInstance();
//        $themeDir = $framework->them()->getDir();
//
//        $framework->render($themeDir . $this->templateFile);
    }
}