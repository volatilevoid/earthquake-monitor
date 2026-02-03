<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Response;

readonly class ProcessEarthquakeDataResponse
{
    public function __construct(
        public bool $success,
        public string $message,
        public array $earthquakesOverThreshold = [],
    ) {}
}
