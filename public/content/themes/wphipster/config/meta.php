<?php

return [
    [
        'id' => 'post_sidebar',
        'title' => __('Sidebar Position', 'angle-admin-td'),
        'priority' => 'high',
        'context' => 'side',
        'pages' => ['post'],
        'fields' => [
            [
                'id' => 'sidebar',
                'type' => 'select',
                'name' => __('Sidebar', 'whipster'),
                'description' => __('This will override theme sidebar position', 'whipster'),
                'default_value' => 'right',
                'rules' => [],
                'template' => '/framework/admin/field/views/select.php',
                'options' => [
                    'disable' => __('Disable', 'whipster'),
                    'right' => __('Right', 'whipster'),
                    'left' => __('Left', 'whipster')
                ],
            ],
            [
                'id' => 'test',
                'type' => 'text',
                'name' => __('Test', 'whipster'),
                'description' => __('This will override theme sidebar position', 'whipster'),
                'default_value' => '',
                'rules' => ['required'],
                'template' => '/framework/admin/field/views/text.php',
            ]
        ]
    ]
];