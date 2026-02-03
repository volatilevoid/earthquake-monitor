<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Handler;

use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;

abstract class AbstractHandler implements HandlerInterface
{
    private ?HandlerInterface $nextHandler;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse
    {
        return $this->nextHandler?->handle($request);
    }
}
