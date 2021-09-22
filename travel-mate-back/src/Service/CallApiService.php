<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService

{
    private $client;

    public function __construct(HttpClientInterface $client)
        {
            $this->client = $client->withOptions([
                'headers' => [
                    //'x-rapidapi-host' => 'spott.p.rapidapi.com',
                    'x-rapidapi-key' => '6e73858b1cmsh20d297c76338f56p196278jsn01eb857d2ae8'
                ],    
            ]);
        }

    public function getCountriesData(): array
    {
        $response = $this->client->request(
            'GET', 
            'https://spott.p.rapidapi.com/places/autocomplete?type=COUNTRY&limit=10'
        );

        return $response->toArray();
    }

    public function getCitiesData($countryCode): array
    {
        $response = $this->client->request(
            'GET', 
            'https://spott.p.rapidapi.com/places/autocomplete?country=' . $countryCode . '&type=CITY&limit=10'
        );     

        return $response->toArray();
    }
}