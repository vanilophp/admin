<?php

declare(strict_types=1);

/**
 * Contains the SetsPredefinedRoutes trait.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-04-05
 *
 */

namespace Vanilo\Admin\Tests\Traits;

use Illuminate\Support\Facades\Route;

trait SetsPredefinedRoutes
{
    private function predefinedRoutes(): void
    {
        Route::get('/home', fn () => true)->name('home');
        Route::get('/login', fn () => true)->name('login');
        Route::get('/logout', fn () => true)->name('logout');
    }
}
