<?php

namespace App\Services\Gateway;

interface EarhtquakeApiServiceInterface
{
    public function getForPeriod(\DateTimeImmutable $from, \DateTimeImmutable $to): array;
}
