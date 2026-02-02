<?php

declare(strict_types=1);

namespace App\Services\DTO;

use App\Services\Helpers\SerializerTrait;

readonly class EarthquakeDTO
{
    use SerializerTrait;

    public function __construct(
        public string $id,
        public string $title,
        public float $magnitude,
        public string $place,
        public \DateTimeImmutable $time,
    ) {}
}
