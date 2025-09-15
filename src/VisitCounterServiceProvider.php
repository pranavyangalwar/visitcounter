<?php

namespace Pranavsy\VisitCounter;

use Illuminate\Support\ServiceProvider;


class VisitCounterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Use a middleware-style hook on every request to increment visit count.
        $this->app['router']->pushMiddlewareToGroup('web', VisitorCounterMiddleware::class);
        Blade::directive('visitcount', function () {
            return "<?php echo \\Pranavsy\\VisitCounter\\VisitCounter::count(); ?>";
        });
    }

    public function register()
    {
        //
    }
}

// Simple middleware class to call VisitCounter::increment()
class VisitorCounterMiddleware
{
    public function handle($request, $next)
    {
        VisitCounter::increment($request);
        return $next($request);
    }
}
