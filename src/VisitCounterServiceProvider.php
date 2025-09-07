<?php

namespace Pranavsy\VisitCounter;

use Illuminate\Support\ServiceProvider;

class VisitCounterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/../config/visit_counter.php' => config_path('visit_counter.php'),
        ], 'config');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/visitcounter'),
        ], 'views');

        // Publish migration stub with timestamped filename
        if (! class_exists('CreateVisitCountersTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_visit_counters_table.php.stub' =>
                database_path('migrations/' . date('Y_m_d_His') . '_create_visit_counters_table.php'),
            ], 'migrations');
        }
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            // Optionally run migrate, but careful with production safety
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        }

        // Load views from your package under namespace 'visitcounter'
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'visitcounter');
    }

    public function register(): void
    {
        // Merge default config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/visit_counter.php',
            'visit_counter'
        );
    }
}
