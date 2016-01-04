<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/12/15
 * Time: 6:49 AM
 */

namespace wp_hipster\admin\field;


class Input_Field extends Field
{

    protected $rules;
    protected $description;
    protected $default_value;

    /**
     * Field constructor.
     * @param $rules
     * @param $type
     * @param $id
     * @param $name
     * @param $description
     * @param $value
     * @param $default_value
     * @param $template
     */
    public function __construct($rules, $type, $id, $name, $description, $value, $default_value, $template)
    {
        parent::__construct($type, $id, $name, $template, $value);
        $this->rules = $rules;
        $this->value = $value;
        $this->description = $description;
        $this->default_value = $default_value;
    }

    /**
     * @return mixed
     */
    public function get_rules()
    {
        return $this->rules;
    }

    /**
     * @return mixed
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function get_default_value()
    {
        return $this->default_value;
    }

}