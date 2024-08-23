<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'header' => false,
        'columns' => [
            'name' => [
                'widget' => [
                    'type' => 'link',
                    'text' => [
                        'bold' => true,
                        'text' => '$model.type',
                    ],
                    'url' => [
                        'route' => 'vanilo.admin.promotion.rule.edit',
                        'parameters' => ['$model.promotion', '$model']
                    ],
                    'onlyIfCan' => 'edit promotions',
                ],
            ],
            'actions' => [
                'title' => '&nbsp;',
                'width' => '10%',
                'valign' => 'middle',
                'widget' => [
                    'type' => 'table_actions',
                    'actions' => [
                        'delete' => [
                            'route' => 'vanilo.admin.promotion.rule.destroy',
                            'parameters' => ['$model.promotion', '$model'],
                            'can' => 'edit promotions',
                        ],
                    ],
                ],
            ],
        ]
    ]
];
