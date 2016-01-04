<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/12/15
 * Time: 5:06 AM
 */

namespace wp_hipster\admin\field;


class Text_Field extends Input_Field
{

    /**
     * @var
     */
    private $attributes;

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
     * @param $attributes
     */
    public function __construct($rules, $type, $id, $name, $description, $value, $default_value, $template, $attributes)
    {
        parent::__construct($rules, $type, $id, $name, $description, $value, $default_value, $template);
        $this->attributes = $attributes;
    }
}