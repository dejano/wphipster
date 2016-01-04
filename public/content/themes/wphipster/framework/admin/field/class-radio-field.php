<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/12/15
 * Time: 6:09 AM
 */

namespace wp_hipster\admin\field;


class Radio_Field extends Input_Field
{
    /**
     * @var
     */
    private $attributes;
    /**
     * @var
     */
    private $options;

    /**
     * RadioField constructor.
     * @param $rules
     * @param $type
     * @param $id
     * @param $name
     * @param $description
     * @param $value
     * @param $default_value
     * @param $template
     * @param $options
     * @param $attributes
     */
    public function __construct($rules, $type, $id, $name, $description, $value, $default_value, $template,
                                $options, $attributes)
    {
        parent::__construct($rules, $type, $id, $name, $description, $value, $default_value, $template);
        $this->attributes = $attributes;
        $this->options = $options;
    }
}