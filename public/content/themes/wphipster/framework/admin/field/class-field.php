<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/12/15
 * Time: 4:55 AM
 */

namespace wp_hipster\admin\field;


abstract class Field
{

    protected $type;
    protected $id;
    protected $name;
    protected $template;
    protected $value;

    /**
     * Field constructor.
     * @param $type
     * @param $id
     * @param $name
     * @param $template
     * @param $value
     */
    public function __construct($type, $id, $name, $template, $value)
    {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->template = $template;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }


}