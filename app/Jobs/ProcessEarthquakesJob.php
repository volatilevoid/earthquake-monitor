<?php

namespace App\Jobs;

use App\Services\Gateway\DTO\Request\GetForPeriodRequest;
use App\Services\Gateway\EarthquakeApiServiceInterface;
use App\UseCase\ProcessEarthquakeData\ProcessEarthquakeDataCommand;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessEarthquakesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(ProcessEarthquakeDataCommand $command, EarthquakeApiServiceInterface $earthquakeApiService): void
    {
        // test
        $to = new \DateTimeImmutable();
        $from = (new \DateTimeImmutable())->modify('-1 day');

        $apiResponse = $earthquakeApiService->getForPeriod(
            new GetForPeriodRequest($from, $to),
        );

        $command->execute(new ProcessEarthquakeDataRequest($apiResponse->earthquakes));
    }
}
