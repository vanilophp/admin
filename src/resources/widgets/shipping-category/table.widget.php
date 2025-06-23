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
                        'route' => 'vanilo.admin.shipping-category.edit',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view shipping categories',
                ],
                'title' => __('Name')
            ],
            'is_fragile' => [
                'title' => __('Is Fragile'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_fragile',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'is_hazardous' => [
                'title' => __('Is Hazardous'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_hazardous',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'is_stackable' => [
                'title' => __('Is Stackable'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_stackable',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'requires_temperature_control' => [
                'title' => __('Requires Temperature Control'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.requires_temperature_control',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'requires_signature' => [
                'title' => __('Requires Signature'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.requires_signature',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
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
