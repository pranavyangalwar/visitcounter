<?php

namespace Pranavsy\VisitCounter;

use Illuminate\Support\ServiceProvider;

class VisitCounterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load package views from resources/views with namespace 'visitcounter'
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'visitcounter');

        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../config/visit_counter.php' => config_path('visit_counter.php'),
        ], 'config');

        // Publish views to the application's resources/views/vendor/visitcounter
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/visitcounter'),
        ], 'views');

        // Publish migration if class does not exist
        if (!class_exists('CreateVisitCountersTable')) {
            $timestamp = date('Y_m_d_His');
            $this->publishes([
                __DIR__ . '/../database/migrations/create_visit_counters_table.php.stub' =>
                database_path("migrations/{$timestamp}_create_visit_counters_table.php"),
            ], 'migrations');
        }
    }

    public function register(): void
    {
        // Merge default package config to allow config override by user
        $this->mergeConfigFrom(
            __DIR__ . '/../config/visit_counter.php',
            'visit_counter'
        );
    }
}
