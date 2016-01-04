<?php
namespace wp_hipster\admin\validator\rules;


use wp_hipster\admin\field\Field;

interface Rule
{

    /**
     * @param Field $field
     * @return String|null String when rule isn't satisfied, otherwise null.
     */
    function validate($field);
}