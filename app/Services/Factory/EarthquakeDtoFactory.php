<?php

declare(strict_types=1);

namespace App\Services\Factory;

use App\Services\DTO\EarthquakeDTO;

class EarthquakeDtoFactory
{
    public function fromArray(array $data): EarthquakeDto
    {
        return new EarthquakeDto(); // TODO
    }
}
