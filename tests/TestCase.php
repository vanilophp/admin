<?php

declare(strict_types=1);

/**
 * Contains the TestCase class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-09
 *
 */

namespace Vanilo\Admin\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlServiceProvider;
use Cviebrock\EloquentSluggable\ServiceProvider as SluggableServiceProvider;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\ServiceProvider as BreadcrumbsServiceProvider;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Providers\ModuleServiceProvider as AppShellModule;
use Konekt\Concord\ConcordServiceProvider;
use Konekt\Gears\Providers\GearsServiceProvider;
use Konekt\LaravelMigrationCompatibility\LaravelMigrationCompatibilityProvider;
use Konekt\Menu\Facades\Menu;
use Konekt\Menu\MenuServiceProvider;
use Laracasts\Flash\FlashServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Vanilo\Admin\Providers\ModuleServiceProvider as VaniloAdminModule;
use Vanilo\Foundation\Providers\ModuleServiceProvider as VaniloFrameworkModule;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(realpath(__DIR__ . '/factories'));
        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            ConcordServiceProvider::class,
            MediaLibraryServiceProvider::class,
            GearsServiceProvider::class,
            LaravelMigrationCompatibilityProvider::class,
            BreadcrumbsServiceProvider::class,
            MenuServiceProvider::class,
            SluggableServiceProvider::class,
            HtmlServiceProvider::class,
            FlashServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Breadcrumbs' => Breadcrumbs::class,
            'Menu' => Menu::class,
            'Form' => FormFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $engine = env('TEST_DB_ENGINE', 'sqlite');
        $app['path.lang'] = __DIR__ . '/lang';
        $app['config']->set('database.default', $engine);
        $app['config']->set('database.connections.' . $engine, [
            'driver' => $engine,
            'database' => 'sqlite' == $engine ? ':memory:' : 'vanilo_test',
            'prefix' => '',
            'host' => env('TEST_DB_HOST', '127.0.0.1'),
            'username' => env('TEST_DB_USERNAME', 'pgsql' === $engine ? 'postgres' : 'root'),
            'password' => env('TEST_DB_PASSWORD', ''),
            'port' => env('TEST_DB_PORT'),
        ]);

        if ('pgsql' === $engine) {
            $app['config']->set("database.connections.{$engine}.charset", 'utf8');
        }
    }

    protected function setUpDatabase($app)
    {
        $this->loadLaravelMigrations();
        $this->artisan('migrate', ['--force' => true]);
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);
        $app['config']->set('concord.modules', [
            AppShellModule::class,
            VaniloFrameworkModule::class,
            VaniloAdminModule::class,
        ]);

        $app['config']->set('auth.providers.users.model', User::class);
    }
}
