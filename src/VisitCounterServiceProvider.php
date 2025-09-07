<?php

namespace Pranavsy\VisitCounter;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class VisitCounterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/visitcounter.php', 'visitcounter');
    }

    public function boot(): void
    {
        // load package views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'visitcounter');

        // publish config + migration when the host app runs “vendor:publish”
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/visitcounter.php' =>
                config_path('visitcounter.php'),

                __DIR__ . '/../database/migrations/create_visit_counters_table.php.stub' =>
                database_path('migrations/' . date('Y_m_d_His') . '_create_visit_counters_table.php'),
            ], 'visitcounter');
        }

        // register the Livewire component
        Livewire::component('visit-counter', Components\VisitCounter::class);
    }
}
