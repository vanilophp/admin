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
                            'route' => 'vanilo.admin.promotion.show',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'view promotions',
                    ],
                    'secondary' => [
                        'text' => '$model.description',
                        'modifier' => sprintf('text_if_empty:%s', __('No description')),
                    ],
                ],
                'title' => __('Promotion'),
            ],
            'status' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => fn ($promo) => vnl_admin_promo_status_color($promo->getStatus()),
                    'text' => '$model',
                    'modifier' => fn ($promo) => $promo->getStatus()->label(),
                ]
            ],
            'validity' => [
                'title' => __('Validity'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'text',
                    'text' => fn ($promo) => vnl_promo_validity_text($promo),
                ]
            ],
            'usage' => [
                'title' => __('Usage'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'raw_html',
                    'html' => function ($promo) {
                        $result = sprintf('%s/%s', $promo->usage_count, $promo->usage_limit ?? '&infin;');
                        if ($promo->usage_limit > 0) {
                            $result .= ' <small class="text-muted">[' . round($promo->usage_count / $promo->usage_limit * 100) . '%]</small>';
                        }

                        return $result;
                    },
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
            'priority' => [
                'title' => __('Priority'),
                'valign' => 'middle',
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
        ]
    ]
];
