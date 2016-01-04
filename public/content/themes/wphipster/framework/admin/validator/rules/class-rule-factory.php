<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/15/15
 * Time: 3:30 PM
 */

namespace wp_hipster\admin\validator\rules;


class Rule_Factory
{

    public static function create($shorthand)
    {
        switch ($shorthand) {
            case 'required':
                return new Required_Rule();

        }

        throw new \InvalidArgumentException("Invalid argument '" . $shorthand . "' supplied.");
    }
}