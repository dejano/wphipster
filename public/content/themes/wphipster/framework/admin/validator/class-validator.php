<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/10/15
 * Time: 3:25 AM
 */

namespace wp_hipster\admin\validator;


use wp_hipster\admin\field\Input_Field;

class Validator
{
    private $error = [];

    /**
     * @param Input_Field $field
     * @return \ArrayObject List of errors if rules failed, otherwise empty list.
     */
    public function validate($field)
    {

        if (!is_a($field, '\wp_hipster\admin\field\Input_Field')) {
            return true;
        }
        /* @var $rule \wp_hipster\admin\validator\rules\Rule */
        foreach ($field->get_rules() as $rule) {
            $message = $rule->validate($field);
            if ($message !== null) {
                $this->error[] = $message;
            }
        }
        return !(boolean)(count($this->error));
    }

    public function getErrorMessage()
    {
        if (count($this->error) > 0) {
            return $this->error;
        }
        return null;
    }

}