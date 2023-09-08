<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;
use Vanilo\Foundation\Features;

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
                            'route' => 'vanilo.admin.shipping-method.edit',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'edit shipping methods',
                    ],
                    'secondary' => [
                        'text' => '$model.getCarrier().name()',
                        'url' => [
                            'route' => 'vanilo.admin.carrier.show',
                            'parameters' => ['$model.carrier'],
                        ],
                        'onlyIfCan' => 'view carriers',
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
            'calculator' => [
                'title' => __('Calculator'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.getCalculator().getName()',
                ],
            ],
            'channels' => [
                'title' => __('Channels'),
                'hideIf' => fn() => Features::isMultiChannelDisabled(),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badges',
                    'color' => 'secondary',
                    'text' => '$model.name',
                    'items' => '$model.channels',
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
