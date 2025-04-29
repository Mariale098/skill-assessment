<?php

namespace Mariale098\Quotes;

use Illuminate\Support\ServiceProvider;

class QuotesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/quotes.php', 'quotes');
        
        $this->app->singleton(Quotes::class, function ($app) {
            return new Quotes(
                $app['cache'],
                $app['config']->get('quotes')
            );
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/quotes.php' => config_path('quotes.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/js/components' => resource_path('js/components'),
            ], 'assets');

            $this->publishes([
                __DIR__.'/../resources/css/app.css' => resource_path('css/app.css'),
            ], 'quotes-styles');
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'quotes');
    }
} 