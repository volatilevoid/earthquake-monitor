<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Request;

use App\Services\DTO\EarthquakeDTO;

class ProcessEarthquakeDataRequest
{
    /**
     * @param EarthquakeDTO[] $earthquakes
     */
    public function __construct(
        private array $earthquakes
    ) {}

    /**
     * @return EarthquakeDTO[]
     */
    public function getEarthquakes(): array
    {
        return $this->earthquakes;
    }

    /**
     * @param EarthquakeDTO[] $earthquakes
     * @return void
     */
    public function setEarthquakes(array $earthquakes): void
    {
        $this->earthquakes = $earthquakes;
    }
}
