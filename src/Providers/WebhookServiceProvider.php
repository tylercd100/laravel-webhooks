<?php

namespace Tylercd100\Laravel\Webhooks\Providers;

use Illuminate\Support\ServiceProvider;
use Tylercd100\Laravel\Webhooks\Listeners\WebhookEventSubscriber;

class WebhookServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/webhooks.php', 'webhooks');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Event stuff
        \Event::subscribe(WebhookEventSubscriber::class);

        // Migrations
        if (method_exists($this, 'loadMigrationsFrom')) {
            $this->loadMigrationsFrom(__DIR__.'/../../migrations');
        } else {
            $this->publishes([
                __DIR__.'/../../migrations/' => database_path('migrations')
            ], 'migrations');
        }

        // Config
        $this->publishes([
            __DIR__.'/../../config/' => base_path('config')
        ], 'config');
    }
}