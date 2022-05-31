<?php

declare(strict_types=1);

use Vanilo\Admin\Models\SkuMode;

return [
    'event_listeners' => true,
    'views' => [
        'namespace' => 'vanilo'
    ],
    'routes' => [
        'prefix' => 'admin',
        'as' => 'vanilo.admin.',
        'middleware' => ['web', 'auth', 'acl'],
        'files' => ['admin']
    ],
    'breadcrumbs' => true,
    'sku' => [
        'hidden' => false,
        'mode' => SkuMode::NANOID
    ],
];
