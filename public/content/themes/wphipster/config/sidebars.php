<?php
return [
    [
        'name' => 'Footer Widget Area',
        'id' => 'footer-widget',
        'description' => 'Displays widgets in footer',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
        'associated' => [
            'id' => 'footer_columns',
            'type' => \wp_hipster\sidebar\WP_Hipster_Association_Type::REPEATABLE
        ]
    ],
    [
        'name' => 'Sidebar Widget Area',
        'id' => 'sidebar-widget',
        'description' => 'Displays widgets in sidebar',
        'before_widget' => '<div class="widget ">',
//        'before_widget' => '<div class="widget widget--colorful-primary">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="title title--widget">',
        'after_title' => '</h2>',
    ]
];