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
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.name',
                        'url' => [
                            'route' => 'vanilo.admin.payment-method.edit',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'edit payment methods',
                    ],
                    'secondary' => [
                        'text' => '$model.getGatewayName()'
                    ],
                ],
                'title' => __('Name'),
            ],
            'transaction_count' => [
                'title' => __('No. of Transactions'),
                'valign' => 'middle',
            ],
            'is_enabled' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_enabled',
                    'modifier' => sprintf('bool2text:%s,%s', __('active'), __('inactive'))
                ]
            ],
            'created_at' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.created_at'
                ],
                'valign' => 'middle',
                'title' => __('Created'),
            ],
        ]
    ]
];
