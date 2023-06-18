<?php

namespace App\Controller;

use App\ArrayService\CleanArray;
use App\DictionaryService\EnglishAndSpanishDictionary;
use App\DictionaryService\SpanishDictionary;
use App\Entity\Word;
use App\MailerService\Sender;
use App\Repository\WordRepository;
use App\WordGenerator\ApiDefinitionGenerator;
use App\WordGenerator\ApiWordGenerator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WordController extends AbstractController
{
    public function __construct(
        private readonly ApiWordGenerator $wordGenerator,
        private readonly WordRepository   $wordRepository,
        private readonly ApiDefinitionGenerator $definitionGenerator,
        private readonly CleanArray $cleanArray,
        private readonly EnglishAndSpanishDictionary $englishAndSpanishDictionary,
        private readonly EntityManagerInterface $em,
        private readonly Sender $sender
    )
    {
    }

    #[Route('/word', name: 'app_word')]
    public function index(): JsonResponse
    {
        $en = 'en';
        $es = 'es';
        $englishWordDefinition = [];
        $spanishWordDefinition = [];
        do {
            $englishWord = str_replace(['[', ']', '"'], '', $this->wordGenerator->getWord($en));
            $spanishWord = str_replace(['[', ']', '"'], '', $this->wordGenerator->getWord($es));


            $englishWordDefinition = $this->englishAndSpanishDictionary->getDefinition($englishWord, $en);

            $spanishWordDefinition = $this->englishAndSpanishDictionary->getDefinition($spanishWord, $es);
        } while (empty($englishWordDefinition) || empty($spanishWordDefinition));

        $englishDbWord = new Word();
        $englishDbWord->setWord($englishWord)
            ->setDefinition(implode(", ", $englishWordDefinition))
            ->setLanguage($en)
            ->setCreationDate(new \DateTime());

        $spanishDbWord = new Word();
        $spanishDbWord->setWord($spanishWord)
            ->setDefinition(implode(", ",$spanishWordDefinition))
            ->setLanguage($es)
            ->setCreationDate(new \DateTime());

        $this->em->persist($englishDbWord);
        $this->em->persist($spanishDbWord);
        $this->em->flush();

        $englishWordInfo = [
            "word" => $englishWord,
            "definitions" => $englishWordDefinition
        ];

        $spanishWordInfo = [
            "word" => $spanishWord,
            "definitions" => $spanishWordDefinition
        ];

        $result = [
            "english" => $englishWordInfo,
            "spanish" => $spanishWordInfo
        ];

        $this->sender->sendEmail($result);
        return $this->json($result);
    }
}