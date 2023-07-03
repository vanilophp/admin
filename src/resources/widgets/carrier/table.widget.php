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
                        'route' => 'vanilo.admin.carrier.edit',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'edit carriers',
                ],
                'title' => __('Name')
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
                'type' => 'show_datetime',
                'title' => __('Created'),
            ],
        ]
    ]
];
