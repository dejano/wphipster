<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/12/15
 * Time: 5:59 AM
 */

namespace wp_hipster\admin\validator\rules;


class Required_Rule implements Rule
{
    private $message;

    function validate($field)
    {
        if (empty(trim($field->getValue()))) {
            return $field->getName() . __(' Is required.', 'whipster');
        }
        return null;
    }
}