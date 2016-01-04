<?php
return array(
    'theme_menu' =>
        [
            'page_title' => __('Whipster', 'whipster'),
            'menu_title' => __('Whipster', 'whipster'),
            'slug' => 'whipster-theme',
            'main_menu' => true,
            'icon' => null,
        ],
    [
        'page_title' => __('General Settings', 'whipster'),
        'menu_title' => __('General Settings', 'whipster'),
        'slug' => 'whipster-general',
        'main_menu' => false,
        'sections' => [
            'layout' => [
                'title' => __('Layout Settings', 'whipster'),
                'header' => __('Layout Settings desc', 'whipster'),
                'fields' => [
                    [
                        'id' => 'swarm',
                        'type' => 'color-picker',
                        'name' => __('Swarm', 'whipster'),
                        'description' => __('Choose theme colors', 'whipster'),
                        'default_value' => 1,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/color-picker.php',
                        'options' => [
                            0 => __('No sidebar', 'whipster'),
                            1 => __('Left', 'whipster'),
                            2 => __('Right', 'whipster')
                        ],
                    ],
                    [
                        'id' => 'primary_color',
                        'type' => 'text',
                        'name' => __('Primary color', 'whipster'),
                        'description' => __('Theme Primary Color', 'whipster'),
                        'default_value' => 'cyan',
                        'rules' => [],
                        'template' => '/framework/admin/field/views/text.php',
                    ],
                    [
                        'id' => 'secondary_color',
                        'type' => 'text',
                        'name' => __('Secondary color', 'whipster'),
                        'description' => __('Theme Secondary Color', 'whipster'),
                        'default_value' => 'purple',
                        'rules' => [],
                        'template' => '/framework/admin/field/views/text.php',
                    ],
                    [
                        'id' => 'lightness',
                        'type' => 'select',
                        'name' => __('Lightness', 'whipster'),
                        'description' => __('Choose light or dark variant', 'whipster'),
                        'default_value' => 0,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/select.php',
                        'options' => [
                            'lighten' => __('Light', 'whipster'),
                            'darken' => __('Dark', 'whipster'),

                        ],
                    ],
                    [
                        'id' => '3d_card',
                        'type' => 'radio',
                        'name' => __('3D Cards', 'whipster'),
                        'description' => __('Use 3D cards for sticky posts', 'whipster'),
                        'default_value' => 0,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => [
                            1 => __('On', 'whipster'),
                            0 => __('Off', 'whipster')
                        ],
                    ],
                    [
                        'id' => 'card_animation',
                        'type' => 'select',
                        'name' => __('Card Hover Animation', 'whipster'),
                        'description' => __('Choose Card hover animation', 'whipster'),
                        'default_value' => 'awesomeness',
                        'rules' => [],
                        'template' => '/framework/admin/field/views/select.php',
                        'options' => [
                            'zoom' => __('Zoom', 'whipster'),
                            'awesomeness' => __('Zoom With Lines', 'whipster'),
                        ],
                    ],
                ]
            ],
        ]
    ],
    [
        'page_title' => __('Header', 'whipster'),
        'menu_title' => __('Header', 'whipster'),
        'slug' => 'whipster-header',
        'main_menu' => false,
        'sections' => [
            'general' => [
                'title' => __('Header settings', 'whipster'),
                'header' => __('Header settings....', 'whipster'),
                'fields' => [
                    [
                        'id' => 'sticky_header',
                        'type' => 'radio',
                        'name' => __('Sticky Header', 'whipster'),
                        'description' => __('Enable this option if you wan\'t header to be always visible on top', 'whipster'),
                        'default_value' => 1,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => [
                            1 => __('On', 'whipster'),
                            0 => __('Off', 'whipster')
                        ],
                    ],
                    [
                        'id' => 'page_loading_effect',
                        'type' => 'select',
                        'name' => __('Page loading effect', 'whipster'),
                        'description' => __('Select preloading effect.', 'whipster'),
                        'default_value' => 'header',
                        'rules' => [],
                        'template' => '/framework/admin/field/views/select.php',
                        'options' => [
                            'header' => __('Header', 'whipster'),
//                            'quad' => __('Quad', 'whipster'),
//                            'circle' => __('Circle', 'whipster'),
                            'disable' => __('Disable', 'whipster')
                        ],
                    ]
                ]
            ],
            'logo' => [
                'title' => __('Logo settings', 'whipster'),
                'header' => __('Logo settings....', 'whipster'),
                'fields' => [
                    [
                        'id' => 'logo_image',
                        'type' => 'field',
                        'name' => __('Logo image', 'whipster'),
                        'description' => __('Display logo image.', 'whipster'),
                        'default_value' => '',
                        'rules' => [],
                        'template' => '/framework/admin/field/views/logo-upload.php',
                    ],
                    [
                        'id' => 'logo_text',
                        'type' => 'text',
                        'name' => __('Logo text', 'whipster'),
                        'description' => __('Set logo text.', 'whipster'),
                        'default_value' => get_bloginfo('name'),
                        'rules' => ['required'],
                        'template' => '/framework/admin/field/views/text.php'
                    ]
                ]
            ],
        ]
    ],
    [
        'page_title' => __('Sidebar', 'whipster'),
        'menu_title' => __('Sidebar', 'whipster'),
        'slug' => 'whipster-sidebar',
        'main_menu' => false,
        'sections' => [
            'logo' => [
                'title' => __('General settings', 'whipster'),
                'header' => __('', 'whipster'),
                'fields' => [
                    [
                        'id' => 'widgets_appearance',
                        'type' => 'select',
                        'name' => __('Widgets appearance', 'whipster'),
                        'description' => __('Select how would you like to display widgets in sidebar.', 'whipster'),
                        'default_value' => 'modern',
                        'rules' => [],
                        'template' => '/framework/admin/field/views/select.php',
                        'options' => [
                            'modern' => __('Modern', 'whipster'),
                            'flip' => __('Flip', 'whipster'),
                            'expand' => __('Expand', 'whipster'),
                            'regular' => __('Regular', 'whipster')
                        ],
                    ],
                    [
                        'id' => 'sidebar',
                        'type' => 'radio',
                        'name' => __('Sidebar', 'whipster'),
                        'description' => __('Choose sidebar option', 'whipster'),
                        'default_value' => 1,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => [
                            0 => __('No sidebar', 'whipster'),
                            1 => __('Left', 'whipster'),
                            2 => __('Right', 'whipster')
                        ],
                    ],
                ]
            ],
        ]
    ],
    [
        'page_title' => __('Advanced settings for theme colors', 'whipster'),
        'menu_title' => __('Colors', 'whipster'),
        'slug' => 'whipster-colors',
        'main_menu' => false,
        'sections' => [
            'header' => array(
                'title' => __('Header Colors Settings', 'whipster'),
                'header' => __('...', 'whipster'),
                'fields' => array(
                    array(
                        'id' => 'logo_text_color',
                        'type' => 'radio',
                        'name' => __('Color for logo text', 'whipster'),
                        'description' => __('Select how many columns will the footer consist of.', 'whipster'),
                        'default_value' => 3,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => array(
                            1 => __('1', 'whipster'),
                            2 => __('2', 'whipster'),
                            3 => __('3', 'whipster'),
                            4 => __('4', 'whipster'),
                        ),
                    ),
                )
            ),
        ]
    ],
    [
        'page_title' => __('Footer', 'whipster'),
        'menu_title' => __('Footer', 'whipster'),
        'slug' => 'whipster-footer',
        'main_menu' => false,
        'sections' => [
            'footer' => array(
                'title' => __('Footer widgets', 'whipster'),
                'header' => __('The footer is the bottom bar of your site.  Here you can set the footer to use 1-4 columns, you can add Widgets to your footer in the Appearance -> Widgets page', 'whipster'),
                'fields' => array(
                    array(
                        'id' => 'footer_columns',
                        'type' => 'radio',
                        'name' => __('Footer Columns', 'whipster'),
                        'description' => __('Select how many columns will the footer consist of.', 'whipster'),
                        'default_value' => 3,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => array(
                            1 => __('1', 'whipster'),
                            2 => __('2', 'whipster'),
                            3 => __('3', 'whipster'),
                            4 => __('4', 'whipster'),
                        ),
                    ),
                    array(
                        'id' => 'large_footer',
                        'type' => 'radio',
                        'name' => __('Large Footer', 'whipster'),
                        'description' => __('If disabled you won\'t be able to see widgets in footer.', 'whipster'),
                        'default_value' => 1,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => array(
                            1 => __('On', 'whipster'),
                            0 => __('Off', 'whipster')
                        ),
                    ),
                    array(
                        'id' => 'scroll_up',
                        'type' => 'radio',
                        'name' => __('Scroll up', 'whipster'),
                        'description' => __('', 'whipster'),
                        'default_value' => 1,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => array(
                            1 => __('On', 'whipster'),
                            0 => __('Off', 'whipster')
                        ),
                    ),
                    array(
                        'id' => 'lower_footer',
                        'type' => 'radio',
                        'name' => __('Lower Footer', 'whipster'),
                        'description' => __('If disabled you won\'t be able to see copyright section in footer.', 'whipster'),
                        'default_value' => 1,
                        'rules' => [],
                        'template' => '/framework/admin/field/views/radio.php',
                        'options' => array(
                            1 => __('On', 'whipster'),
                            0 => __('Off', 'whipster')
                        ),
                    ),
                    array(
                        //id must be globally unique
                        'id' => 'footer_copyright',
                        'type' => 'text',
                        'name' => __('Footer Copyright', 'whipster'),
                        'description' => __('Copyright text to be printed in footer.', 'whipster'),
                        'default_value' => 'Copyright ' . get_bloginfo('name') . ' 2015',
                        'rules' => ['required'],
                        'template' => '/framework/admin/field/views/text.php',
                    )
                )
            ),
        ]
    ],
);