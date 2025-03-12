<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;
use Vanilo\Foundation\Models\Order;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'columns' => [
            'number' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.number',
                        'url' => [
                            'route' => 'vanilo.admin.order.show',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'view orders',
                    ],
                    'secondary' => [
                        'text' => '$model.billpayer.getName()',
                    ],
                ],
                'title' => __('Number'),
            ],
            'ordered' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.ordered_at',
                        'type' => 'show_datetime',
                        'bold' => false,
                    ],
                    'secondary' => [
                        'text' => fn (Order $order) => format_price($order->total()),
                    ],
                ],
                'title' => __('Ordered'),
            ],
            'shipping' => [
                'title' => __('Ship To'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.getShippingAddress().getCity()',
                        'bold' => false,
                    ],
                    'secondary' => [
                        'text' => '$model.getShippingAddress().country.name',
                    ],
                ],
            ],
            'payment_method' => [
                'title' => __('Payment Method'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => 'dark',
                    'text' => fn ($order) => $order->paymentMethod?->name ?? $order->currentPayment->method->name,
                ]
            ],
            'status' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['enum_color' => '$model.status'],
                    'text' => '$model.status.label()',
                ]
            ],
        ]
    ]
];
