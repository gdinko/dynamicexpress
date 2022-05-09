<?php

namespace Gdinko\DynamicExpress;

use Gdinko\DynamicExpress\Commands\GetCarrierDynamicExpressApiStatus;
use Gdinko\DynamicExpress\Commands\SyncCarrierDynamicExpressAll;
use Gdinko\DynamicExpress\Commands\SyncCarrierDynamicExpressCities;
use Gdinko\DynamicExpress\Commands\SyncCarrierDynamicExpressCountries;
use Gdinko\DynamicExpress\Commands\SyncCarrierDynamicExpressOffices;


use Illuminate\Support\ServiceProvider;

class DynamicExpressServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/dynamicexpress.php' => config_path('dynamicexpress.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                SyncCarrierDynamicExpressAll::class,
                SyncCarrierDynamicExpressCountries::class,
                SyncCarrierDynamicExpressCities::class,
                SyncCarrierDynamicExpressOffices::class,
                GetCarrierDynamicExpressApiStatus::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/dynamicexpress.php', 'dynamicexpress');

        // Register the main class to use with the facade
        $this->app->singleton('dynamicexpress', function () {
            return new DynamicExpress();
        });
    }
}
