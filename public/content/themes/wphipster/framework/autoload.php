<?php

require_once(dirname(__DIR__)  . '/framework/utils/otf_regen_thumbs.php');

if (!function_exists('wp_hipster_framework_autoloader')) {
    function wp_hipster_framework_autoloader($class_name)
    {
        $class_name = str_replace('wp_hipster\\', '/framework/', $class_name);
        $filename = dirname(__DIR__) . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
        $basename = basename($filename);
        $filename = str_replace($basename, 'class-' . strtolower($basename), $filename);
        $filename = str_replace('_', '-', $filename);

        if (file_exists($filename)) {
//            print_r($filename);
//            print_r('<br>');
            require_once($filename);
        }
    }

    spl_autoload_register('wp_hipster_framework_autoloader');
}

