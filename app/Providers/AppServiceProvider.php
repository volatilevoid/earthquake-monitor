<?php

namespace App\Providers;

use App\Jobs\ProcessEarthquakesJob;
use App\Services\Gateway\EarthquakeApiServiceInterface;
use App\UseCase\ProcessEarthquakeData\ProcessEarthquakeDataCommand;
use Illuminate\Contracts\Foundation\Application;
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
        $this->app->bindMethod([ProcessEarthquakesJob::class, 'handle'], function (ProcessEarthquakesJob $job, Application $app) {
            return $job->handle($app->make(ProcessEarthquakeDataCommand::class), $app->make(EarthquakeApiServiceInterface::class));
        });
    }
}
