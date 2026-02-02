<?php

declare(strict_types=1);

namespace App\Services\DTO;

use App\Services\Helpers\SerializerTrait;

readonly class Metadata
{
    use SerializerTrait;

    public function __construct(
        public \DateTimeImmutable $generated,
        public string $url,
        public string $title,
        public int $status,
        public string $api,
        public int $count
    ) {}
}
