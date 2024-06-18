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
            'slug' => [
                'title' => __('Slug'),
            ],
            'domain' => [
                'title' => __('Domain'),
            ],
            'currency' => [
                'title' => __('Currency'),
                'widget' => [
                    'type' => 'badge',
                    'color' => 'secondary',
                    'text' => '$model.currency',
                ],
            ],
            'country' => [
                'title' => __('Country'),
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.configuration.country_id',
                ],
            ],
            'language' => [
                'title' => __('Language'),
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.language',
                ],
            ],
            'created_at' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.created_at'
                ],
                'title' => __('Created'),
            ],
        ]
    ]
];
