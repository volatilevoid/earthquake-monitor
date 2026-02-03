<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData;

use App\UseCase\ProcessEarthquakeData\Handler\CheckThresholdHandler;
use App\UseCase\ProcessEarthquakeData\Handler\NotifyUsersHandler;
use App\UseCase\ProcessEarthquakeData\Handler\PersistEarthquakeHandler;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;

class ProcessEarthquakeDataCommand
{
    public function __construct(
        private readonly CheckThresholdHandler $checkThresholdHandler,
        private readonly PersistEarthquakeHandler $persistEarthquakeHandler,
        private readonly NotifyUsersHandler $notifyUsersHandler,
    ) {}

    public function execute(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse
    {
        $this->checkThresholdHandler
            ->setNext($this->persistEarthquakeHandler)
            ->setNext($this->notifyUsersHandler);

        return $this->checkThresholdHandler->handle($request);
    }
}
