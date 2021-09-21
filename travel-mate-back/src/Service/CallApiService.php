<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService 
{

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCountries(): array 
    {

        $response = $this->client->request(
            'GET',
            'https://coronavirusapi-france.now.sh/FranceLiveGlobalData'
        );

        return $response->toArray();
    }
}