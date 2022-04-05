<?php

declare(strict_types=1);

/**
 * Contains the TestCase class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-04-05
 *
 */

namespace Vanilo\Admin\Tests\Functional;

use Konekt\AppShell\Models\User;
use Konekt\User\Models\UserType;
use Vanilo\Admin\Tests\Traits\SetsPredefinedRoutes;

class TestCase extends \Vanilo\Admin\Tests\TestCase
{
    use SetsPredefinedRoutes;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'email' => 'admin@vanilo.net',
            'type' => UserType::ADMIN,
            'name' => 'Adminelli Adminovich',
            'password' => '123456, what else?',
        ]);
        $this->admin->assignRole('admin');
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $this->predefinedRoutes();
    }
}
