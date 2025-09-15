<?php

namespace Pranavsy\VisitCounter;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class VisitCounter
{
    protected const CACHE_KEY = 'visitor_counter_visits';

    /**
     * Increment visit count for the current visitor IP.
     *
     * @param Request|null $request
     * @return void
     */
    public static function increment(Request $request = null): void
    {
        $request = $request ?? request();
        $ip = $request->ip();

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return;
        }

        $visits = Cache::get(self::CACHE_KEY, []);

        // Increment only once per IP per session (optional)
        if (!isset($visits[$ip])) {
            $visits[$ip] = 1;
        } else {
            $visits[$ip]++;
        }

        Cache::forever(self::CACHE_KEY, $visits);
    }

    /**
     * Get total visit count.
     *
     * @return int
     */
    public static function count(): int
    {
        $visits = Cache::get(self::CACHE_KEY, []);
        return array_sum($visits);
    }
}
