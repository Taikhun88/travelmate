<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Service permettant de récupérer des informations d'une série
 * à partir depuis le site https://rapidapi.com/wirefreethought/api/geodb-cities/
 */
class CallApiService

{
    private $client;

    public function __construct(HttpClientInterface $client)
        {
            $this->client = $client->withOptions([
                'headers' => [
                    //'x-rapidapi-host' => 'spott.p.rapidapi.com',
                    'x-rapidapi-key' => '591bcba6cemsh9e0f51ea6c0ad4ep1af5a9jsnc3878cb79cc0'
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