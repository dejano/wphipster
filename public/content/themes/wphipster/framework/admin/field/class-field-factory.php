<?php

namespace wp_hipster\admin\field;


use wp_hipster\admin\validator\rules\Rule_Factory;

class Field_Factory
{
    private $field_types;

    /**
     * Field_Factory constructor.
     * @param $field_types
     */
    public function __construct($field_types)
    {
        $this->field_types = $field_types;
    }


    public function register_field_type($name, $class)
    {
        if (!is_a($class, '_field')) {
            throw new \InvalidArgumentException("_type " . $class . "doesn't extend \\_whipster\\admin\\field\\_field class");
        }
        $this->field_types[$name] = $class;
    }

    public function create($arguments)
    {

        if (!isset($arguments['type'])) {
            throw new \InvalidArgumentException("Type must be provided.");
        }

        $type = $arguments['type'];

        if (isset($this->field_types[$type])) {
            $arguments = $this->create_rules($arguments);

            $reflection = new \ReflectionClass($this->field_types[$type]);
            $arguments = $this->validate_arguments_and_rearrange($arguments, $reflection);

            return $reflection->newInstanceArgs($arguments);
        }

        throw new \UnexpectedValueException("Field type '" . $type . "' is not supported.
         Check wp_hipster\\admin\\field\\Field_Factory class");
    }

    /**
     * @param $arguments array
     * @param $reflection \ReflectionClass
     * @return array
     * @throws \InvalidArgumentException
     */
    private function validate_arguments_and_rearrange($arguments, $reflection)
    {
        $values = [];
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();
        /**
         * @var $param \ReflectionParameter
         */
        foreach ($params as $param) {
            $name = $param->getName();
            if (!isset($arguments[$name])) {
                throw new \InvalidArgumentException($arguments['id'] . " is missing '" . $name . "' key in options settings.");
            }
            $position = $param->getPosition();
            $values[$position] = $arguments[$name];
        }

        return $values;
    }

    /**
     * @return mixed
     */
    public function get_field_types()
    {
        return $this->field_types;
    }

    /**
     * @param $arguments array
     * @return array
     */
    public function create_rules($arguments)
    {
        if (!empty($arguments['rules']) && is_string($arguments['rules'][0])) {
            $rules = [];
            $rules_shorthand = explode('|', $arguments['rules'][0]);
            foreach ($rules_shorthand as $rule) {
                $rules[] = Rule_Factory::create($rule);
            }
            $arguments['rules'] = $rules;
        }
        return $arguments;
    }

}