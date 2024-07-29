<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'empty' => [
            'text' => __('There are no coupons set for this promotion'),
        ],
        'hover' => true,
        'columns' => [
            'code' => [
                'widget' => [
                    'type' => 'link',
                    'text' => [
                        'bold' => true,
                        'text' => '$model.code',
                    ],
                    'url' => [
                        'route' => 'vanilo.admin.coupon.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view coupons',
                ],
                'title' => __('Code')
            ],
            'expires_at' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.expires_at'
                ],
                'title' => __('Expires at'),
            ],
            'usage_count' => [
                'title' => __('Used'),
                'widget' => [
                    'type' => 'badge',
                    'color' => fn ($count) => 0 > $count ? 'primary' : 'secondary',
                    'text' => '$model.usage_count',
                    'suffix' => __(' times'),
                ],
            ],
            'usage_limit' => [
                'title' => __('Usage Limit'),
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.usage_limit',
                    'modifier' => fn ($limit) => null === $limit ? __('Unlimited') : $limit,
                ],
            ],
            'per_customer_usage_limit' => [
                'title' => __('Limit per Customer'),
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.per_customer_usage_limit',
                    'modifier' => fn ($limit) => null === $limit ? __('Unlimited') : $limit,
                ],
            ],
        ]
    ]
];
