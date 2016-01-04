<?php
namespace wp_hipster\core;


/**
 * Trait Magic_Properties
 * @package WPhipster\core
 */
trait Magic_Properties
{

    function import($info, $force = false)
    {
        if (is_object($info)) {
            $info = get_object_vars($info);
        }
        if (is_array($info)) {
            foreach ($info as $key => $value) {
                if (!empty($key) && $force) {
                    $this->$key = $value;
                } else if (!empty($key) && !method_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }
}