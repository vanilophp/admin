<?php

declare(strict_types=1);

return [
    'event_listeners' => true,
    'views' => [
        'namespace' => 'vanilo'
    ],
    'routes' => [
        [
            'prefix' => 'admin',
            'as' => 'vanilo.admin.',
            'middleware' => ['web', 'auth', 'acl'],
            'files' => ['admin'],
        ],
        [
            'prefix' => 'admin',
            'as' => 'vanilo.admin.alt.',
            'middleware' => ['web', 'auth'],
            'files' => ['nonacl'],
        ],
    ],
    'breadcrumbs' => true,
];
