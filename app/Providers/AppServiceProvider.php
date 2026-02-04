<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('earthquakes-public', function (Request $request) {
            return Limit::perMinute(1)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'You can make only one call per minute. Please try again later'
                    ], 429);
                });
        });
    }
}
