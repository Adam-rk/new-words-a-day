<?php

namespace App\DictionaryService;


use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EnglishAndSpanishDictionary
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    )
    {
    }

    public function getDefinition(string $word, string $language): array
    {
        $uri = '';
        switch ($language) {
            case 'en':
                $uri = 'https://www.wordreference.com/definition/';
                break;
            case 'es':
                $uri = 'https://www.wordreference.com/definicion/';
                break;
        }

        $response = $this->httpClient->request('GET', $uri . $word);
        $htmlContent = $response->getContent();

        $crawler = new Crawler($htmlContent);

        if ('en' === $language) {

            $definitions = $crawler->filter('.rh_def')->each(function (Crawler $node) {
                return $node->text();
            });
        } else {
            $definitions = $crawler->filter('ol.entry li')->each(function (Crawler $node) {
                return $node->text();

            });
        }

        return $definitions;
    }
}