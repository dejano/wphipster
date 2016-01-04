<?php

namespace wp_hipster\widget;

class WP_Hipster_Socials_Widget extends WP_Hipster_Widget
{
    /**
     * Specifies the widget name, description, class name and instatiates it
     */
    public function __construct()
    {
        parent::__construct(
            'whipster-socials-widget',
            __('Whipster: Socials Widget', 'whipster'),
            array(
                'classname' => 'whipster-socials-widget',
                'description' => __('A custom widget that displays social links.', 'whipster'),
                'template' => '/framework/widget/social-widget.twig'
            )
        );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        parent::widget($args, $instance);
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     * @return string|void
     */
    public function form($instance)
    {
        return parent::form($instance);
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update($new_instance, $old_instance)
    {
        return parent::update($new_instance, $old_instance); // TODO: Change the autogenerated stub
    }

}