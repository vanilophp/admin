<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;
use Vanilo\Support\Features;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'columns' => [
            'icon' => [
                'valign' => 'middle',
                'widget' => [
                    'type' => 'raw_html',
                    'html' => fn ($method) => '<div class="gwicon" title="' . $method->getGatewayName() . '"><style>.gwicon svg{max-width: 100%; height: auto}</style>' . $method->getGatewayIcon() . '</div>',
                ],
                'title' => '&nbsp;',
            ],
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
            'zone' => [
                'title' => __('Zone'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['info', 'secondary']],
                    'text' => '$model.zone.name',
                    'modifier' => sprintf('text_if_empty:%s', __('Unrestricted'))
                ]
            ],
            'transaction_count' => [
                'title' => __('No. of Transactions'),
                'valign' => 'middle',
            ],
            'channels' => [
                'title' => __('Channels'),
                'hideIf' => fn () => Features::isMultiChannelDisabled(),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badges',
                    'color' => 'secondary',
                    'text' => '$model.name',
                    'items' => '$model.channels',
                ]
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
