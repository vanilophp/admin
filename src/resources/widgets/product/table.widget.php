<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'columns' => [
            'thumbnail' => [
                'widget' => [
                    'type' => 'image',
                    'model' => '$model.getThumbnailUrl()',
                    'style' => 'height: 2.5em',
                    'fallback' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC8AAAAjCAMAAAAzO6PlAAAAt1BMVEX///+tq6u2tLSXlZW0srKenJ2LiYqzsLGZmJiNi4yqqKmvra2cmpqRj5CmpKSPjY6koqKUk5O4traopqagnp+Ih4exr6/Mycq5t7fOzMy7ubmioKCGhIWTkZLEwsK9u7vCv8DV09PS0NDQzs7Jx8fHxcWBgIF/fX58envX1dXZ19eDgoNwb3C/vb3U0dH7+vt1dHXh4eHe29vb2dl4d3j39/dpaGrx8fHo5+djYmPt7e309PRbW1zggo2RAAAC0UlEQVQ4y22T23qCMBCEA6LWA1qlchIBBaViPdVabe37P1dnN4GU72su9OafnZkNER9FsYs6Y7v11H55dvqDruknaZx72WG53Zbl5Z3O5VJut8vDapWJ12ITzTrjRZNfe8FqWQkUnAWB54lis4tmPc27lh/umV8doICgrOF8vSZ+1unZFW+41pT4PMgyFiia4ThNBY1H/AnzI8Wn69yTAhyaDTqO030SCsJ7DV4V9oIAgkOD9k0RMb/QPBf27pkUAKckTE9NyxXAEV/zvKDtURzfSQBaDqfZVndgiBmNR93WsOaTu6BzDzyKklfDQfcdgfEyfs3HDyHPdempLKE/peHOaC6AN3lkqc9ZFa3xtuDxNe9YlEWfb6/G+87zvP0k+UXFx1fRPMfDPgzVdOAtgTg1Pyo1qDMlqOoafeDDlt3gje9/+NseazeQ5mXYWozBc37e5/wfg3PIe+9zGruj5hM/BO+kzQLXwOc0BpedjGfM0z4p0BwfaPf+dz1p6KvxHIf4vwWcbNA3VsdqN5ck3Jd+V/LUttfk0feR9o3kxvgjT8LgKm6Ja6jtLMDje1CBkGcJrDSMwZmL+gn9v1su7kry4w6+N31jw3b4QGjTMLxbYJkxfK45x+f8TxPwkRJMIEAk54zcHiy6FvW4hxbx3Jf22RMRPxjlQJ09YGd3YN0h3E5NrMcd0HVRoImN9ygdtMDCLd+CB35iX/PSYCI2m91OWti2FMxHF3mzpjnFE2SeDdCgJYqigAQe9bPBtcVXFMVLNnm+MmCBeMWBQj97+o6e3YuFl2+Bl4EqQVucPj4gKMhCvXskwsPBS3PBk0ElIIV4O51OUEgBSksD4mGgBRQJFiPxhqMEqoI2IB4C1YEV4vMTAlhAIBNpgwEaT32fLZTCEF9fULADJdIGzMPA91lRScCzQBtUgVQBPwxDLbHEz48W7CJeEQWSBZhPEkgq0S8ch3VdK2koBAAAAABJRU5ErkJggg==',
                ],
            ],
            'name' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.name',
                        'url' => fn ($product) => route(sprintf('vanilo.admin.%s.show', is_master_product($product) ? 'master_product' : 'product'), $product),
                        'onlyIfCan' => 'view products',
                    ],
                    'secondary' => [
                        'text' => '$model.sku',
                        'tooltip' => __('SKU'),
                    ],
                ],
                'title' => __('Name'),
            ],
            'sales' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.units_sold',
                        'bold' => false,
                        'suffix' => ' ' . __('units sold'),
                    ],
                    'secondary' => [
                        'text' => '$model.last_sale_at',
                        'type' => 'show_datetime',
                        'unknown' => __('never'),
                        'prefix' => __('Last sale') . ' ',
                    ],
                ],
                'title' => __('Sales'),
            ],
            'taxons' => [
                'title' => __('Categorization'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badges',
                    'color' => 'secondary',
                    'text' => '$model.name',
                    'items' => '$model.taxons',
                ]
            ],
            'state' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['enum_color' => '$model.state'],
                    'text' => '$model.state.label()',
                ]
            ],
        ]
    ]
];
