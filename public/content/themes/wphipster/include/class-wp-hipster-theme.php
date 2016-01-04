<?php

use Leafo\ScssPhp\Compiler;

/**
 * Class WP_Hipster_Theme
 */
class WP_Hipster_Theme extends \wp_hipster\core\Theme
{

    private $cached_categories_as_string = [];
    private $colors;
    private $wave_class;

    /**
     * WPHipsterTheme constructor.
     * @param \wp_hipster\core\WP_Hipster_Builder $builder
     */
    public function __construct($builder)
    {
        parent::__construct($builder);
        $this->colors = new WP_Hipster_Colors();
        $this->init();
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
//        add_action('wp_hipster/core/admin/after_settings_field_save/layout_primary_color', [$this, 'after_primary_color_save'], 10, 3);
//        add_action('wp_hipster/core/admin/after_settings_field_save/layout_secondary_color', [$this, 'after_secondary_color_save'], 10, 3);
        add_action('wp_hipster/core/admin/after_settings_field_save', [$this, 'after_settings_field_save'], 10, 2);
    }

    public function get_color($name, $lightness = 'base')
    {
        return $this->colors->color($name, $lightness);
    }

    function after_settings_field_save($options, $old_options)
    {
        $has_changed = $options['primary_color'] != $old_options['primary_color'] ||
            $options['secondary_color'] != $old_options['secondary_color'] ||
            $options['neutral_color'] != $old_options['neutral_color'] ||
            $options['lightness'] != $old_options['lightness'];
        if ($has_changed) {
            if ($options['lightness'] == 'lighten') {
                $lightness = 'lighten';
                $this->wave_class = 'waves-light';
            } else {
                $this->wave_class = 'waves-dark';
                $lightness = 'darken';
            }
            $scss = <<<SCSS
\$lightness: "$lightness";
\$primary-color-string: "{$options['primary_color']}";
\$secondary-color-string: "{$options['secondary_color']}";
\$neutral-color: color("{$options['primary_color']}", "$lightness-3");
SCSS;
            $filename = dirname(__FILE__) . '/../static/scss/_swarm.scss';
            file_put_contents($filename, $scss . PHP_EOL);

            SassCompiler::run($this->get_assets_dir() . '/scss/', $this->get_assets_dir() . '/css/');
        }
    }

    function after_primary_color_save($field, $value, $old_value)
    {
        if ($value != $old_value) {
            $scss = <<<EOT
\$primary-color: color($value, "base");
EOT;
            // TODO: This is temporary
            $filename = dirname(__FILE__) . '/_swarm.scss';
            file_put_contents($filename, $scss . PHP_EOL);

            SassCompiler::run($this->get_assets_dir() . '/scss/', $this->get_assets_dir() . '/css/');
        }
    }

    function after_secondary_color_save($field, $value, $old_value)
    {
        if ($value != $old_value) {
            $scss = <<<EOT
\$secondary-color: color($value, "base");
EOT;
            // TODO: This is temporary
            $filename = dirname(__FILE__) . '/_swarm.scss';
            file_put_contents($filename, $scss . PHP_EOL, FILE_APPEND);

            SassCompiler::run($this->get_assets_dir() . '/scss/', $this->get_assets_dir() . '/css/');
        }
    }

    public
    function enqueue_assets()
    {
        $protocol = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "");

        wp_register_script('$-global', $this->get_assets_uri() . '/js/jquery-global.js', ['jquery'], false, true);
        wp_enqueue_script('$-global');

        wp_register_script('mainjs', $this->get_assets_uri() . '/js/main.js', ['color-thief'], false, true);
        wp_enqueue_script('mainjs');

        wp_register_script('magnific-popup', $this->get_uri() . '/bower_components/magnific-popup/dist/jquery.magnific-popup.js', ['jquery'], false, true);
        wp_enqueue_script('magnific-popup');

        wp_register_script('intense', $this->get_assets_uri() . '/js/intense.min.js', [], false, true);
        wp_enqueue_script('intense');

        wp_register_script('color-thief', $this->get_uri() . '/bower_components/color-thief/src/color-thief.js', ['velocity-ui-js'], false, true);
        wp_enqueue_script('color-thief');


        wp_enqueue_script('material-js', $this->get_uri() . '/bower_components/Materialize/dist/js/materialize.min.js', ['$-global'], false, true);


        wp_register_script('velocity-ui-js', $this->get_uri() . '/bower_components/velocity/velocity.ui.min.js', ['material-js'], false, true);
        wp_enqueue_script('velocity-ui-js');

        wp_enqueue_script('smooth-scroll', $this->get_assets_uri() . '/js/smoothscroll.js', [], false, true);

//        wp_enqueue_style('material-style', $this->get_uri() . '/bower_components/Materialize/bin/materialize.css', []);
//        wp_enqueue_style('theme-style', $this->get_assets_uri() . '/css/theme.css', []);
        wp_enqueue_style('main-style', $this->get_assets_uri() . '/css/global.css', ['magnific-popup-style']);
        wp_enqueue_style('magnific-popup-style', $this->get_uri() . '/bower_components/magnific-popup/dist/magnific-popup.css', []);
        wp_enqueue_style('animate-style', $this->get_uri() . '/bower_components/animate.css/animate.min.css', []);
        wp_enqueue_style('material-fonts', $protocol . '://fonts.googleapis.com/icon?family=Material+Icons', []);
    }


    function pagination($pages = '', $range = 2, $infinite = false, $echo = true)
    {
        global $wp_query;
        global $paged;
        $output = '';
        if ($infinite == false) {
            $switch = 'pages';
            // we don't use infinite pagination , show display the chosen pagination style
            switch ($switch) {
                case 'next_prev':
                    if ($wp_query->max_num_pages > 1) {
                        $output .= '<nav id="nav-below" class="post-navigation padded">';
                        $output .= '<ul class="pager">';
                        $output .= '<li class="previous">' . get_next_posts_link(__(' <span class="hex-alt"><i class="fa fa-angle-left"></i></span>Previous', 'angle-td')) . '</li>';
                        $output .= '<li class="next">' . get_previous_posts_link(__('Next<span class="hex-alt"><i class="fa fa-angle-right"></i></span>', 'angle-td')) . '</li>';
                        $output .= '</ul>';
                        $output .= '</nav>';
                    }
                    break;
                case 'pages':
                default:
                    $showitems = ($range * 2) + 1;
                    if (empty($paged)) {
                        $paged = 1;
                    }

                    if ($pages == '') {
                        global $wp_query;
                        $pages = $wp_query->max_num_pages;
                        if (!$pages) {
                            $pages = 1;
                        }
                    }

                    $extraClass = "";
                    if (1 != $pages) {
                        $output .= '<div class="text-center ' . $extraClass . '"><ul class="post-navigation pagination">';
                        $output .= ($paged > 1) ? "<li><a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a></li>" : "<li class='disabled'><a>&lsaquo;</a></li>";

                        for ($i = 1; $i <= $pages; $i++) {
                            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                                $output .= ($paged == $i) ? '<li class="btn btn-floating btn-tiny waves-effect waves-light active "><span class="current">' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link($i) . '" class="inactive">' . $i . '</a></li>';
                            }
                        }

                        $output .= ($paged < $pages) ? "<li><a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a></li>" : "<li class='disabled'><a>&rsaquo;</a></li>";
                        $output .= "</ul></div>\n";
                    }
                    break;
            }
        } else {
            // lazy loading is on , hide pagination but preserve 'next' link
            $output .= '<div class="infinite-scroll" ><a href="' . get_pagenum_link($paged + 1) . '">&rsaquo;</a></div>';
        }


        if ($echo == true) {
            echo $output;
        } else {
            return $output;
        }
    }

    /**
     * Customize comments form
     *
     * @param array $args
     * @param null $post_id
     */
    function comment_form($args = array(), $post_id = null)
    {
        global $user_identity, $id;

        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();

        $req = get_option('require_name_email');
        $aria_req = ($req ? " required aria-required='true'" : '');
        $fields = [
            'author' => '<div class="input-field col m6 s12">'
                . '<input id="author" ' . $aria_req . ' name="author" type="text" class="validate" value="' . esc_attr($commenter['comment_author']) . '">'
                . '<label for="author">' . __('Name *', 'wphipster') . '</label>'
                . '</div>',
            'email' => '<div class="input-field col m6 s12">'
                . '<input id="email" ' . $aria_req . ' name="email" type="email" class="validate" value="' . esc_attr($commenter['comment_author_email']) . '">'
                . '<label data-error="' . __('Invalid Email Address', 'wphipster') . '" for="email">' . __('Email *', 'wphipster') . '</label>'
                . '</div>',

//            'author' => '<input id="author" name="author" placeholder="' . __('Name *', 'wphipster') . '" type="text" class="input-block-level form-control" value="' . esc_attr($commenter['comment_author']) . '"/>',
//            'email' => '<input id="email" name="email" placeholder="' . __('Email *', 'wphipster') . '" type="text" class="input-block-level form-control" value="' . esc_attr($commenter['comment_author_email']) . '" />',
            'url' => '',
        ];

        $required_text = sprintf(' ' . __('Required fields are marked %s', 'wphipster'), '<span class="required"><a>*</a></span>');
        $defaults = array(
            'fields' => apply_filters('comment_form_default_fields', $fields),
            'comment_field' => '<div class="input-field col s12">' .
                '<textarea required="" aria-required="true" id="comment" class="materialize-textarea" name="comment"></textarea>' .
                '<label for="comment">' . __('Comment *', 'wphipster') . '</label>' .
                '</div>',
            'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'angle-td'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'angle-td'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
//            'comment_notes_before' => '',
//            'comment_notes_after' => '',

            'id_form' => 'commentform',
            'id_submit' => 'submit',
            'class_form' => '',
            'submit_field' => '%1$s %2$s',
            'class_submit' => 'input-field waves-effect waves-light btn btn-small right comment-submit',
            'title_reply' => __('Leave a Comment', 'wphipster'),
            'title_reply_to' => __('Leave a Reply', 'wphipster'),
            'cancel_reply_link' => __('Cancel reply', 'wphipster'),
            'label_submit' => __('Comment', 'wphipster'),
//            'cancel_reply_before' => '',
//            'cancel_reply_after' => '',
            'format' => 'html5'
        );

        add_action('comment_form_before', function () {
            echo '<div class="card-panel col s12 m12">';
        });

        add_action('comment_form_after', function () {
            echo '</div>';
        });
//        apply_filters('cancel_comment_reply_link', function ($formatted_link, $link, $text) {
//            return '';
//        });
//        cancel_comment_reply_link('Cancel')
        $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
        comment_form($args);

    }

    public
    function categories_as_string()
    {
        global $post;

        if (isset($this->cached_categories_as_string[$post->ID])) {
            return $this->cached_categories_as_string[$post->ID];
        }

        $categories = wp_get_post_categories($post->ID, ['fields' => 'all']);
        $categories_as_string = '';
        foreach ($categories as $category) {
            if (strlen($categories_as_string) > 0) {
                $categories_as_string .= ', ';
            }
            $link = get_term_link($category);
            $categories_as_string .=
                "<a href=\"$link\" title=\"View all posts in $category->name\" rel=\"category tag\">$category->name</a>";
        }

        $this->cached_categories_as_string[$post->ID] = $categories_as_string;
        return $this->cached_categories_as_string[$post->ID];
    }

    private
    function init()
    {
        add_image_size('full-width', 1280, 512, array('center', 'center'));
        add_filter('image_size_names_choose', function ($sizes) {
            return array_merge($sizes, array(
                'full-width' => __('Your Custom Size Name', 'wphipster'),
            ));
        });


        add_filter('image_resize_dimensions', function ($default, $orig_w, $orig_h, $new_w, $new_h, $crop) {
            if (!$crop) return null; // let the wordpress default function handle this

            $aspect_ratio = $orig_w / $orig_h;
            $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

            $crop_w = round($new_w / $size_ratio);
            $crop_h = round($new_h / $size_ratio);

            $s_x = floor(($orig_w - $crop_w) / 2);
            $s_y = floor(($orig_h - $crop_h) / 2);

            return array(0, 0, (int)$s_x, (int)$s_y, (int)$new_w, (int)$new_h, (int)$crop_w, (int)$crop_h);
        }, 10, 6);

        /*   --------------- add a wrapper for the embeded videos -------------*/
        add_filter('embed_oembed_html', [$this, 'wrap_video_embed'], 10, 3);

        add_filter('post_gallery', [$this, 'my_post_gallery'], 10, 2);
    }

    function my_post_gallery($output, $attr)
    {
        global $post;

        if (!empty($attr['ids'])) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if (empty($attr['orderby']))
                $attr['orderby'] = 'post__in';
            $attr['include'] = $attr['ids'];
        }

        // Allow plugins/themes to override the default gallery template.
//        $output = apply_filters('post_gallery', '', $attr);
        if ($output != '')
            return $output;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if (isset($attr['orderby'])) {
            $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
            if (!$attr['orderby'])
                unset($attr['orderby']);
        }

        extract(shortcode_atts(array(
            'order' => 'ASC',
            'orderby' => 'menu_order ID',
            'id' => $post->ID,
            'itemtag' => 'dl',
            'icontag' => 'dt',
            'captiontag' => 'dd',
            'columns' => '3',
            'size' => 'thumbnail',
            'include' => '',
            'exclude' => ''
        ), $attr));

        $id = intval($id);
        if ('RAND' == $order)
            $orderby = 'none';

        if (!empty($include)) {
            $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby, 'posts_per_page' => -1));

            $attachments = array();
            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif (!empty($exclude)) {
            $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        } else {
            $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        }

        if (empty($attachments))
            return '';

        if (is_feed()) {
            $output = "\n";
            foreach ($attachments as $att_id => $attachment)
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }

        $columns = intval($columns);
        $span_width = $columns > 0 ? floor(12 / $columns) : 12;
        $data_links = array();

        foreach ($attachments as $id => $attachment) {
            $full = wp_get_attachment_image_src($id, 'full');
            $data_links[$id] = $full[0];
        }

        $output = '<div class="magnific-gallery">';
        $row = 1;
        foreach ($attachments as $id => $attachment) {
            $thumb = wp_get_attachment_image_src($id, $size);
            $full = wp_get_attachment_image_src($id, 'full');
            $data = $this->attachment_info($attachment);
            // add the item clicked first in the gallery
            foreach ($data_links as $key => $value) {
                if ($value === $full[0]) {
                    $idx = $key;
                    $add_to_front = $value;
                }
            }
            unset($data_links[$idx]);
            array_unshift($data_links, $add_to_front);
            $str_data_links = implode(",", $data_links);

            if ($row == 1) {
                $output .= '<div class="row">';
            }

            $output .= '<div class="col magnific-gallery-item m' . $span_width . '">';
            $output .= '<figure class="magnific-gallery-figure">';
            $output .= '<a class="left card hoverable" href="' . $full[0] . '" >';
            $output .= '<img class="responsive-img waves-effect waves-light" aria-describedby="gallery-' . $id . '" src="' . $thumb[0] . '" alt="' . $data['alt'] . '">';
            $output .= '</a>';
            $output .= '<figurecaption class="magnific-gallery-caption" id="gallery-' . $id . '">' . $data['caption'] . '</figurecaption>';
            $output .= '</figure>';
            $output .= '</div>';


            if ($row == $columns) {
                $output .= '</div>';
                $row = 0;
            }

            $row++;
        }

        if ($row > 1) {
            $output .= '</div>';
        }

        $output .= '</div>';
        return $output;
    }

    function wrap_video_embed($html, $url, $attr)
    {
        $videoSites = [
            'animoto.com',
            'blip.tv',
            'cloudup.com',
            'collegehumor.com',
            'dailymotion.com',
            'flickr.com',
            'funnyordie.com',
            'hulu.com',
            'ted.com',
            'videopress.com',
            'vimeo.com',
            'vine.co',
            'wordpress.tv',
            'youtube.com'
        ];
        $parsed_url = parse_url($url);
        $found = false;

        foreach ($videoSites as $videoSite) {
            if (strpos($parsed_url['host'], $videoSite) !== false) {
                $found = true;
                break;
            }
        }

        if ($found) {
            return '<div class="video-container">' . $html . '</div>';
        }

        return $html;

    }

    public
    function tags_with_hash_tag($echo = true)
    {
        global $post;
        $tags = wp_get_post_tags($post->ID);
        $html = '';
        foreach ($tags as $tag) {
            $html .= '<a href="' . esc_url(get_term_link($tag->term_id)) . '" rel="tag">#' . $tag->name . '</a> ';
        }
        if (!$echo) {
            return $html;
        }

        echo $html;
    }

    public
    function get_image_alt($id, $echo = true)
    {
        $alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
        if (!$echo) {
            return $alt;
        }

        echo $alt;
    }

    public
    function attachment_info($attachment)
    {
        $data['alt'] = $this->get_image_alt($attachment->ID, false);
        $data['title'] = $attachment->post_title;
        $data['caption'] = $attachment->post_excerpt;
        $data['description'] = $attachment->post_content;

        return $data;
    }

    /**
     * @return string
     */
    public function get_wave_class()
    {
        return $this->wave_class;
    }

}