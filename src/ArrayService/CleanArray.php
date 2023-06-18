<?php

namespace App\ArrayService;

class CleanArray
{
    public function cleanEnglishWordArray (array $englishWordInfo): array
    {
        unset($englishWordInfo['meanings'][0]['synonyms']);
        unset($englishWordInfo['meanings'][0]['antonyms']);
        unset($englishWordInfo['license']);
        unset($englishWordInfo['sourceUrls']);
        unset($englishWordInfo['phonetic']);
        unset($englishWordInfo['phonetics']);
        foreach ($englishWordInfo['meanings'][0]['definitions'] as &$definition) {
            unset($definition['synonyms']);
            unset($definition['antonyms']);
        }
        return $englishWordInfo;
    }
}