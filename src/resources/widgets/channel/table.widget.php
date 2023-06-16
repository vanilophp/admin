<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'columns' => [
            'name' => [
                'widget' => [
                    'type' => 'link',
                    'text' => [
                        'bold' => true,
                        'text' => '$model.name',
                    ],
                    'url' => [
                        'route' => 'vanilo.admin.channel.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view channels',
                ],
                'title' => __('Name')
            ],
            'slug',
            'country' => [
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.configuration.country_id',
                ],
            ],
            'created_at' => [
                'type' => 'show_datetime',
                'title' => __('Created'),
            ],
        ]
    ]
];
