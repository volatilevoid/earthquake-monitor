<?php

declare(strict_types=1);

namespace App\Services\DTO;

class EarthquakeDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly float $magnitude,
        public readonly string $place,
        public readonly \DateTime $time,
    ) {}
}
