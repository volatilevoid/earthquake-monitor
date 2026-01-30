<?php

declare(strict_types=1);

namespace App\Services\Gateway;

use App\Services\DTO\Request\GetForPeriodRequest;
use App\Services\DTO\Response\GetForPeriodresponse;
use App\Services\Factory\EarthquakeDtoFactory;
use App\Services\Factory\Response\GetForPeriodresponseFactory;
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
        private readonly GetForPeriodresponseFactory $getForPeriodresponseFactory
    ) {
        $this->http = Http::baseUrl(self::BASE_URL . '/' . self::API_VERSION)->acceptJson();
    }

    public function getForPeriod(GetForPeriodRequest $request): GetForPeriodresponse
    {
        $response = $this->http->get('query', [
            'format' => self::RESPONSE_FORMAT,
            'starttime' => $request->from->format(self::DATE_FORMAT),
            'endtime' => $request->from->format(self::DATE_FORMAT)
        ]);

        if ($response->failed()) {
            return new GetForPeriodresponse(false, 'Unable to fetch earthquake data');
        }

        return $this->getForPeriodresponseFactory->fromApiResponse($response->json());
    }
}
