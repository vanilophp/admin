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
                        'route' => 'vanilo.admin.promotion.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view promotions',
                ],
                'title' => __('Name')
            ],
            'priority' => [
                'title' => __('Priority'),
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.priority',
                ],
            ],
            'is_exclusive' => [
                'title' => __('Exclusive'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_exclusive',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'is_coupon_based' => [
                'title' => __('Coupon Based'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_coupon_based',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'applies_to_discounted' => [
                'title' => __('Applies to Discounted'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.applies_to_discounted',
                    'modifier' => sprintf('bool2text:%s,%s', __('yes'), __('no'))
                ]
            ],
            'starts_at' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.starts_at'
                ],
                'title' => __('Starts at'),
            ],
            'ends_at' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.ends_at'
                ],
                'title' => __('Ends at'),
            ],
        ]
    ]
];
