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
                        'route' => 'vanilo.admin.promotion.action.edit',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'edit promotions',
                ],
            ],
        ]
    ]
];
