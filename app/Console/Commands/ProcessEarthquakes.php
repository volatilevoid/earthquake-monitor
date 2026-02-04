<?php

namespace App\Console\Commands;

use App\Models\LastProcessEarthquakesRunLog;
use App\Services\Gateway\DTO\Request\GetForPeriodRequest;
use App\Services\Gateway\EarthquakeApiServiceInterface;
use App\UseCase\ProcessEarthquakeData\ProcessEarthquakeDataCommand;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use Illuminate\Console\Command;

class ProcessEarthquakes extends Command
{
    private const MAX_RETRIES = 5;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-earthquakes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch earthquakes from external API, persist them and notify users based on config threshold';

    /**
     * Execute the console command.
     */
    public function handle(ProcessEarthquakeDataCommand $command, EarthquakeApiServiceInterface $earthquakeApiService)
    {
        $lastRun = LastProcessEarthquakesRunLog::first();

        if (!is_null($lastRun)) {
            $lastRun = \Datetime::createFromFormat('Y-m-d H:i:s', $lastRun->finished_at);
        }

        $to = new \DateTimeImmutable();
        $from = is_null($lastRun) ? (new \DateTimeImmutable())->modify('-1 hours') : $lastRun;

        $i = 0;
        $success = false;

        while (!$success && $i < self::MAX_RETRIES) {
            $apiResponse = $earthquakeApiService->getForPeriod(
                new GetForPeriodRequest($from, $to),
            );

            $success = $apiResponse->success;
        }

        if (!$success) {
            $this->error('Failed to retrieve earthquakes from external API');

            return self::FAILURE;
        }

        $processResult = $command->execute(new ProcessEarthquakeDataRequest($apiResponse->earthquakes));


        return $processResult->success ? self::SUCCESS : self::FAILURE;
    }
}
