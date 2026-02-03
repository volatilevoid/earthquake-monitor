<?php

namespace App\UseCase\ProcessEarthquakeData\Handler;

use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;

interface HandlerInterface
{
    public function setNext(HandlerInterface $handler): HandlerInterface;
    public function handle(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse;
}
