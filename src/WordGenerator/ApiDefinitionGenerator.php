<?php

namespace App\WordGenerator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiDefinitionGenerator
{
    public function __construct(
        private readonly HttpClientInterface $client
    )
    {
    }

    public function getWordDefinition (string $word, string $language) {
        $response = $this->client->request(
            'GET',
            'https://api.dictionaryapi.dev/api/v2/entries/en/'.$word,
            [
                'headers' => [
                    'X-RapidAPI-Host' => 'dictionary-by-api-ninjas.p.rapidapi.com',
                    'X-RapidAPI-Key' => '3ae6f2c415mshf2ee96b2cf213fcp1a7f3fjsn0d3a05a986ec'
                ]
            ]
        );


        return $response->getContent();
    }
}