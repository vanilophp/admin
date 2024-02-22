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
                        'route' => 'vanilo.admin.tax-category.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view tax categories',
                ],
                'title' => __('Name')
            ],
            'type' => [
                'title' => __('Type'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => fn ($type) => enum_color($type),
                    'text' => '$model.type',
                ]
            ],
            'is_active' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_active',
                    'modifier' => sprintf('bool2text:%s,%s', __('active'), __('inactive'))
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
