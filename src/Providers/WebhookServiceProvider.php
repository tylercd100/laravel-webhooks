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
    }
}