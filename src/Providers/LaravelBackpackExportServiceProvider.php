<?php

namespace Jargoud\LaravelBackpackExport\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelBackpackExportServiceProvider extends ServiceProvider
{
    public const NAMESPACE = 'laravel-backpack-export';

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', self::NAMESPACE);

        if ($this->app->runningInConsole()) {
            $this->publishViews();
        }
    }

    protected function publishViews(): self
    {
        $this->publishes(
            [
                __DIR__ . '/../resources/views' => resource_path('views/vendor/' . self::NAMESPACE),
            ],
            'views'
        );

        return $this;
    }
}
