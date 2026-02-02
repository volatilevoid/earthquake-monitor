<?php

declare(strict_types=1);

namespace App\Services\Gateway\DTO\Request;

readonly class GetForPeriodRequest
{
    public function __construct(
        public \DateTimeImmutable $from,
        public \DateTimeImmutable $to,
    ) {}
}
