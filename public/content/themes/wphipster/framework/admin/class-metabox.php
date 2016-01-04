<?php


namespace wp_hipster\admin;


class Metabox
{
    const NONCE_SUFFIX = '_nonce';

    private $meta_config;
    private $framework;
    private $field_factory;
    private $field_validator;

    /**
     * Hook into the appropriate actions when the class is constructed. sufix
     * @param $framework
     * @param $field_factory
     * @param $field_validator
     * @param array $meta_config
     */
    public function __construct($framework, $field_factory, $field_validator, $meta_config)
    {
        $this->framework = $framework;

        $this->meta_config = $meta_config;

        if (isset($this->meta_config['pages'])) {
            foreach ($this->meta_config['pages'] as $page) {
                add_action('add_meta_boxes_' . $page, array(&$this, 'add_meta_box'));
            }
        }
        add_action('save_post', array(&$this, 'save'));
        add_action('admin_notices', [&$this, 'metabox_admin_notices']);
        $this->field_factory = $field_factory;
        $this->field_validator = $field_validator;
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box()
    {
        foreach ($this->meta_config['pages'] as $page) {
            add_meta_box($this->meta_config['id'], $this->meta_config['title'], array(&$this, 'render_meta_box_content'), $page, $this->meta_config['context'], $this->meta_config['priority']);
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     * @return int
     */
    public function save($post_id)
    {
        $is_valid_nonce = (isset($_POST['WP_HIPSTER_metabox_nonce']) &&
            wp_verify_nonce($_POST['WP_HIPSTER_metabox_nonce'], 'WP_HIPSTER_metabox')) ? 'true' : 'false';


        // Checks save status
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);

        // Exits script depending on save status
        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        foreach ($this->meta_config['pages'] as $page) {
            if (!current_user_can('edit_' . $page, $post_id)) {
                return;
            }
        }

        /* OK, its safe for us to save the data now. */
        foreach ($this->meta_config['fields'] as $field) {
            // Sanitize the user input.
            $key = WPHIPSTER_OPTIONS_NAME . '_meta_' . $this->meta_config['id'] . '_' . $field['id'];
            $value = sanitize_text_field($_POST[WPHIPSTER_OPTIONS_NAME][$field['id']]);

            $field['value'] = $value;
            $field['attributes'] = [];
            $to_validate = $this->field_factory->create($field);
            $is_valid = $this->field_validator->validate($to_validate);
//            var_dump($to_validate);
//            var_dump($to_validate);
            if (!$is_valid) {
                delete_post_meta($post_id, $key);
                add_settings_error($key, $field['id'], $this->field_validator->getErrorMessage());
                set_transient('wp_hipster_metabox_errors', get_settings_errors(), 30);
            } else {
                if (empty($value)) {
                    delete_post_meta($post_id, $key);
                } else {
                    update_post_meta($post_id, $key, $value);
                }
            }
        }
    }

    /**
     * Writes an error message to the screen if the 'Plan' meta data is not specified for the current
     * post.
     *
     * @since    1.0.0
     */
    function metabox_admin_notices()
    {
        // If there are no errors, then we'll exit the function
        if (!($errors = get_transient('wp_hipster_metabox_errors'))) {
            return;
        }
        // Otherwise, build the list of errors that exist in the settings errores
        $message = '<div id="wphipster-metabox-error-message" class="update-nag below-h2"><p><ul>';
        foreach ($errors as $error) {
            foreach ($error['message'] as $e) {
                $message .= '<li>' . $e . '</li>';
            }
        }
        $message .= '</ul></p></div><!-- #error -->';
        // Write them out to the screen
        echo $message;
        // Clear and the transient and unhook any other notices so we don't see duplicate messages
        delete_transient('wp_hipster_metabox_errors');
        remove_action('admin_notices', [&$this, 'metabox_admin_notices']);
    }


    /**
     * Render Meta Box content.
     *
     * @param \WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
    {
        foreach ($this->meta_config['fields'] as $field) {
            $id = WPHIPSTER_OPTIONS_NAME . '[' . $field['id'] . ']';
            $key = WPHIPSTER_OPTIONS_NAME . '_meta_' . $this->meta_config['id'] . '_' . $field['id'];

            if (is_object($post)) {
                $field['value'] = get_post_meta($post->ID, $key, true);
            } else {
                $field['value'] = $field['default'];
            }

            $field['option_name'] = $id;

            include $this->framework->get_theme()->get_dir() . $field['template'];
        }
        // create nonce
        wp_nonce_field('WP_HIPSTER_metabox', 'WP_HIPSTER_metabox_nonce');
    }
}