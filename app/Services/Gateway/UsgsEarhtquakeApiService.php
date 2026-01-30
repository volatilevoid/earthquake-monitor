<?php

declare(strict_types=1);

namespace App\Services\Gateway;

use App\Services\Factory\EarthquakeDtoFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class UsgsEarhtquakeApiService implements EarhtquakeApiServiceInterface
{
    private const BASE_URL = 'https://earthquake.usgs.gov/fdsnws/event';
    private const API_VERSION = '1';

    private const RESPONSE_FORMAT = 'geojson';
    private const DATE_FORMAT = '';

    private PendingRequest $http;

    public function __construct(
        private readonly EarthquakeDtoFactory $earthquakeDtoFactory
    ) {
        $this->http = Http::baseUrl(self::BASE_URL . '/' . self::API_VERSION)->acceptJson();
    }

    public function getForPeriod(\DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $response = $this->http->get('query', [
            'format' => self::RESPONSE_FORMAT,
            'starttime' => $from->format(self::DATE_FORMAT),
            'endtime' => $to->format(self::DATE_FORMAT)
        ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'message' => 'Unable to fetch earthquake data'
            ];
        }

        return $response->json();
    }
}
