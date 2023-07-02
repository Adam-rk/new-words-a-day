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

    public function cleanWord(array $word):array {
        $cleanArray = [];

        foreach ($word as $key => $value) {
            $key = str_replace("\x00App\Entity\Word\x00", "", $key);
            $cleanArray[$key] = $value;
        }
        return $cleanArray;
    }

    public function cleanWordsArray(array $words): array {
        $cleanMatrix = [];
        for ($i = 0; $i < count($words); $i++) {
            foreach ($words[$i] as $key => $value) {
                $key = str_replace("\x00App\Entity\Word\x00", "", $key);
                if ($key === 'id' ||$key === 'word') {
                    $cleanMatrix[$i][$key] = $value;
                }
            }
        }
        return $cleanMatrix;
    }
}