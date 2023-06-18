<?php

namespace App\WordGenerator;

use App\Repository\WordRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiWordGenerator
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly WordRepository $wordRepository
    )
    {
    }

    public function getWord($language): string
    {
        if ('en' === $language) {
            do {
                $response = $this->client->request(
                    'GET',
                    'https://random-word-api.herokuapp.com/word'
                );
                $wordInDb = $this->wordRepository->findOneBy(["word" => $response->getContent(), "language" => "en"]);

            } while(null !== $wordInDb);
        } elseif ('es' === $language) {
            do {
                $response = $this->client->request(
                    'GET',
                    'https://random-word-api.herokuapp.com/word?lang=es'
                );
                $wordInDb = $this->wordRepository->findOneBy(["word" => $response->getContent(), "language" => "es"]);
            }while(null !== $wordInDb);
        } else {
            throw new HttpException(404, 'No language found');
        }

         return $response->getContent();
    }
}