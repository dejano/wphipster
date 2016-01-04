<?php

namespace wp_hipster\admin;

use wp_hipster\admin\field\Field;
use wp_hipster\admin\field\Field_Factory;
use wp_hipster\admin\validator\Validator;
use wp_hipster\core\WP_Hipster;

class WP_Hipster_Admin
{
    private $framework;
    private $main_menu_item;
    private $option_pages;
    private $options;
    private $context;
    private $fields;
    private $field_factory;
    private $field_validator;
    private $metabox_config;


    /**
     * WP_Hipster_Admin constructor.
     * @param WP_Hipster $framework
     */
    public function __construct($framework)
    {
        $this->framework = $framework;
        $this->field_factory = new Field_Factory([
            'text' => '\wp_hipster\admin\field\Text_Field',
            'select' => '\wp_hipster\admin\field\Select_Field',
            'radio' => '\wp_hipster\admin\field\Radio_Field',
            'color-picker' => '\wp_hipster\admin\field\Color_Picker',
            'field' => '\wp_hipster\admin\field\Input_Field',
            'hidden' => '\wp_hipster\admin\field\Hidden_Field',
        ]);
        $this->field_validator = new Validator();
        $this->context = [];
        $this->options = [];
        $this->fields = [];
        $this->option_pages = require_once($this->framework->get_theme()->get_dir() . $this->framework->get_options_file_path());
        $this->main_menu_item = $this->option_pages['theme_menu'];
        unset($this->option_pages['theme_menu']);

        $this->metabox_config = require_once($this->framework->get_theme()->get_dir() . '/config/meta.php');
        foreach ($this->metabox_config as $metabox) {
            $metabox = new Metabox($framework, $this->field_factory, $this->field_validator, $metabox);
        }

        do_action('wp_hipster/admin/field_factory_init', $this->field_factory);

        add_action('admin_enqueue_scripts', [$this, 'assets']);
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_init', [$this, 'admin_init']);

        add_action('wp_ajax_wphipster_is_logged_in', [$this, 'is_logged_in']);
        add_action('wp_ajax_nopriv_wphipster_is_logged_in', [$this, 'is_logged_in']);
    }

    public function is_logged_in()
    {
        $return['isLoggedIn'] = is_user_logged_in();
        echo json_encode($return);
        die();
    }

    public function assets($hook)
    {
        if (strpos($hook, 'whipster_page') === false) {
            return;
        }

        $uri = $this->framework->get_theme()->get_uri();

        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        } else {
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }

        wp_register_script('material-script-admin', $uri . '/bower_components/material-design-lite/material.min.js', [], false, true);
        wp_register_script('wphispter-media-upload', $uri . '/static/js/media-upload.js', ['jquery'], false, true);
        wp_enqueue_script('material-script-admin');
        wp_enqueue_script('wphispter-media-upload');

        wp_enqueue_style('material-style-admin', $uri . '/bower_components/material-design-lite/material.min.css', []);
        wp_enqueue_style('material-style-admin', 'https://fonts.googleapis.com/icon?family=Material+Icons', []);


        do_action('wp_hipster/core/admin/after_wp_enqueue_scripts');
    }

    public function admin_menu()
    {
        add_menu_page($this->main_menu_item['page_title'], $this->main_menu_item['menu_title'], 'manage_options',
            $this->main_menu_item['slug'], [$this, 'option_page_html'], $this->main_menu_item['icon']);

        foreach ($this->option_pages as $option) {
            if ($option['main_menu']) {
                add_submenu_page($this->main_menu_item['slug'], $option['page_title'], $option['menu_title'], 'manage_options', $this->main_menu_item['slug'], [$this, 'option_page_html']);
                continue;
            }
            add_submenu_page('whipster-theme', $option['page_title'], $option['menu_title'], 'manage_options', $option['slug'], array($this, 'option_page_html'));
        }
    }

    public
    function admin_init()
    {
        $this->options = get_option(WPHIPSTER_OPTIONS_NAME);
        if (false === $this->options) {
            $this->default_options();
            add_option(WPHIPSTER_OPTIONS_NAME, $this->options);
        } else {
            $this->update_missing_options();
            update_option(WPHIPSTER_OPTIONS_NAME, $this->options);
        }
        register_setting(WPHIPSTER_OPTIONS_GROUP, WPHIPSTER_OPTIONS_NAME, array(&$this, 'validate_options'));

        do_action('wp_hipster/core/admin/before_add_settings_field');
        foreach ($this->option_pages as $option) {
            foreach ($option['sections'] as $id => $section) {
                add_settings_section($id, $section['title'], [$this, 'section_html'], $option['slug']);

                foreach ($section['fields'] as $field) {
                    $field = $this->prepare_field($field);
                    $this->fields[$field['id']] = $this->field_factory->create($field);

                    do_action('wp_hipster/core/admin/before_add_settings_field/' . $id . '_' . $field['id'], $field);

                    add_settings_field($field['id'], $field['name'], [$this, 'field_html'], $option['slug'], $id, $field);

                    do_action('wp_hipster/core/admin/after_add_settings_field/' . $id . '_' . $field['id'], $field);
                }
            }
        }
        do_action('wp_hipster/core/admin/after_add_settings_field');

    }

    public
    function validate_options($input)
    {
        do_action('wp_hipster/core/admin/before_settings_field_save');
        if (isset($_POST['reset_options'])) {
            // reset defaults button was pressed, so we reset this page to default options
            $url = parse_url(wp_get_referer());
            parse_str($url['query'], $path);
            $slug = $path['page'];
            $this->default_page_options($slug);
            return $this->options;
        }
        $options_old = $this->options;
        foreach ($this->option_pages as $option) {
            foreach ($option['sections'] as $id => $section) {
                foreach ($section['fields'] as $field) {
                    if (isset($input[$field['id']])) {
                        $this->evaluate_field($field, $input);
                        if (!empty($field['rules'])) {
                            /**
                             * @var $to_validate Field
                             */
                            $to_validate = $this->fields[$field['id']];
                            $to_validate->setValue($input[$to_validate->getId()]);
                            $is_valid = $this->field_validator->validate($to_validate);

                            if (!$is_valid) {
                                add_settings_error(
                                    $id,
                                    $field['id'],
                                    $this->field_validator->getErrorMessage()
                                );
                            } else {
                                $this->options[$field['id']] = $input[$field['id']];
                            }
                        } else {
                            do_action('wp_hipster/core/admin/before_settings_field_save/' . $id . '_' . $field['id'],
                                $field, $input[$field['id']]);
                            $old_value = $this->options[$field['id']];

                            $this->options[$field['id']] = $input[$field['id']];

                            do_action('wp_hipster/core/admin/after_settings_field_save/' . $id . '_' . $field['id'],
                                $field, $input[$field['id']], $old_value);
                        }

                    }
                }
            }
        }
        do_action('wp_hipster/core/admin/after_settings_field_save', $this->options, $options_old);
        return $this->options;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function prepare_field($field)
    {
        if (isset($this->options[$field['id']])) {
            $field['value'] = $this->options[$field['id']];
        } else {
            $field['value'] = $field['default_value'];
        }
        if (!isset($field['attributes'])) {
            $field['attributes'] = [];
        }
        $field['label_for'] = $field['id'];
        return $field;
    }

    private function update_missing_options()
    {
        foreach ($this->option_pages as $page) {
            foreach ($page['sections'] as $section) {
                foreach ($section['fields'] as $field) {
                    if (isset($field['default_value'])) {
                        if (!isset($this->options[$field['id']])) {
                            $this->options[$field['id']] = $field['default_value'];
                        }
                    }
                }
            }
        }
    }

    private
    function default_options()
    {
        foreach ($this->option_pages as $page) {
            foreach ($page['sections'] as $section) {
                foreach ($section['fields'] as $field) {
                    if (isset($field['default_value'])) {
                        $this->options[$field['id']] = $field['default_value'];
                    }
                }
            }
        }
    }

    private function default_page_options($slug)
    {
        foreach ($this->option_pages as $page) {
            if ($page['slug'] === $slug) {
                foreach ($page['sections'] as $section) {
                    foreach ($section['fields'] as $field) {
                        if (isset($field['default_value'])) {
                            $this->options[$field['id']] = $field['default_value'];
                        }
                    }
                }
                break;
            }

        }
    }

    public
    function option_page_html()
    {
        // Check that the user is allowed to update options
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }
        $page = $_GET['page'];

        do_action('wp_hipster/' . $page . '_before_page', $this->context);

        include $this->framework->get_theme()->get_dir() . '/framework/admin/views/options.php';

        do_action('wp_hipster/' . $page . '_after_page', $this->context);
    }

    public
    function section_html($data)
    {
//        print_r($data);
        $section_description = '';
        foreach ($this->option_pages as $option) {
            foreach ($option['sections'] as $id => $section) {
                if ($id == $data['id']) {
                    if (isset($section['header'])) {
                        $section_description = $section['header'];
                    }
                    break;
                }
            }
        }
        include $this->framework->get_theme()->get_dir() . '/framework/admin/views/section.php';
    }

    public
    function field_html($field)
    {
        // TODO: template is accessible in $field, maybe there is no need for fieldObject atm.
        /**
         * @var $fieldObject Field
         */
//        if (isset($field['display']) && !$field['display']) {
//            return;
//        }
        $field['display'] = isset($field['display']) ? $field['display'] : true;

        $fieldObject = $this->fields[$field['id']];
        $field['option_name'] = WPHIPSTER_OPTIONS_NAME . '[' . $field['id'] . ']';
//        $option_name = WPHIPSTER_OPTIONS_NAME . '[' . $field['id'] . ']';
//        $errors = get_settings_errors();
//        $field['errors'] = [];
//        foreach ($errors as $error) {
//            if ($error['code'] == $field['id']) {
//                $field['errors'][] = $error;
//            }
//        }

        include $this->framework->get_theme()->get_dir() . $fieldObject->getTemplate();
    }

    public function evaluate_field(&$field, &$input)
    {
        if (!isset($field['display']) || $field['display']) {
            return;
        }
//        $field['value'] = $input[$field['id']];
//        $input[$field['id']] = $field['default_value'];
    }

}