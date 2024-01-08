<?php

namespace Webkul\BagistoConnector\Providers;

use Illuminate\Support\ServiceProvider;

class BagistoConnectorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../Http/helpers.php';

        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->publishes([
            dirname(__DIR__) . '/Config/webhook-client.php' => config_path('webhook-client.php'),
            dirname(__DIR__) . '/Config/webhook-server.php' => config_path('webhook-server.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
    */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
