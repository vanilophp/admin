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
                        'route' => 'vanilo.admin.tax-rate.edit',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'edit tax rates',
                ],
                'title' => __('Name')
            ],
            'category' => [
                'title' => __('Category'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.getTaxCategory().name',
                ]
            ],
            'zone' => [
                'title' => __('Zone'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => 'info',
                    'text' => '$model.zone.name',
                ]
            ],
            'rate' => [
                'title' => __('Rate'),
                'widget' => ['type' => 'text', 'text' => '$model.rate', 'suffix' => '%'],
            ],
            'calculator' => [
                'title' => __('Calculator'),
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
            'valid_from' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.valid_from'
                ],
                'title' => __('Valid from'),
            ],
            'valid_until' => [
                'widget' => [
                    'type' => 'show_datetime',
                    'text' => '$model.valid_until'
                ],
                'title' => __('Valid until'),
            ],
            'actions' => [
                'title' => '&nbsp;',
                'width' => '10%',
                'valign' => 'middle',
                'widget' => [
                    'type' => 'table_actions',
                    'actions' => [
                        'delete' => [
                            'route' => 'vanilo.admin.tax-rate.destroy',
                            'can' => 'delete tax rates',
                        ],
                    ],
                ],
            ],
        ]
    ]
];
