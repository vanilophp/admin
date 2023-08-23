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
                        'route' => 'vanilo.admin.property.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view properties',
                ],
                'title' => __('Name')
            ],
            'slug' => [
                'title' => __('Slug'),
                'valign' => 'middle',
            ],
            'type' => [
                'title' => __('Type'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => 'secondary',
                    'text' => '$model.type',
                ]
            ],
            'is_hidden' => [
                'title' => __('Visibility'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['secondary', 'success']],
                    'text' => '$model.is_hidden',
                    'modifier' => sprintf('bool2text:%s,%s', __('hidden'), __('visible'))
                ]
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
