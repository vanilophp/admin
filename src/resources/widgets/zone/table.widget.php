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
                        'route' => 'vanilo.admin.zone.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view channels',
                ],
                'title' => __('Name')
            ],
            'scope' => [
                'title' => __('Scope'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => fn ($scope) => enum_color($scope),
                    'text' => '$model.scope',
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
