<?php

namespace Sarfraznawaz2005\Meter;

use Laravel\Lumen\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Sarfraznawaz2005\Meter\Console\PruneCommand;
use Sarfraznawaz2005\Meter\Console\PublishCommand;
use Sarfraznawaz2005\Meter\Console\ServerMonitorCommand;

class MeterServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/Config/config.php' => config_path('meter.php')], 'meter-config');
            $this->publishes([__DIR__ . '/Migrations' => database_path('migrations')], 'meter-migration');
            $this->publishes([__DIR__ . '/Resources/Views' => resource_path('views/vendor/meter')], 'meter-views');
            $this->publishes([__DIR__ . '/Resources/Assets' => public_path('vendor/meter')], 'meter-assets');
        }

        if (!config('meter.enabled')) {
            return;
        }

        $this->registerDbConnection();

        Meter::start($this->app);

        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'meter');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->app->router->group([
            'domain' => config('meter.domain', null),
            'namespace' => 'Sarfraznawaz2005\Meter\Http\Controllers',
            'prefix' => config('meter.path'),
            'middleware' => 'auth.basic_meter',
        ], function ($router){
            require __DIR__ . '/Http/routes.php';
        });
    }

    // see: https://github.com/sarfraznawaz2005/meter/issues/2
    // see: https://github.com/laravel/framework/issues/25768
    protected function registerDbConnection()
    {
        $defaultConnection = config('database.default');

        config(['database.connections.meter' => config("database.connections.{$defaultConnection}")]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/config.php', 'meter');

        $this->commands([
            PruneCommand::class,
            PublishCommand::class,
            ServerMonitorCommand::class,
        ]);

        $this->app->singleton('meter', static function () {
            return new Meter;
        });
    }
}
