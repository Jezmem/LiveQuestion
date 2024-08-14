<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des réponses
        $answers = [
            ['question' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'answer_text' => 'Oui, ils ont fait un excellent parcours jusqu\'à présent.'],
            ['question' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'answer_text' => 'La France a montré de grandes performances, surtout en défense.'],
            ['question' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'answer_text' => 'La France a montré de grandes performances, surtout en défense.'],

            ['question' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ?', 'answer_text' => 'Je préfère CS2 pour son gameplay classique, mais Valorant a ses avantages.'],
            ['question' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ?', 'answer_text' => 'Valorant a un côté stratégique plus prononcé, mais CS2 reste un classique indémodable.'],

            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'answer_text' => 'Sa performance était exceptionnelle, il a vraiment incarné le personnage.'],
            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'answer_text' => 'Pierre Niney a vraiment su capturer l\'essence du personnage, une performance incroyable.'],
            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'answer_text' => 'Pierre Niney a vraiment su capturer l\'essence du personnage, une performance incroyable.'],
            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'answer_text' => 'Je pense qu’il a réussi à rendre justice au personnage d’une manière impressionnante.'],

            ['question' => 'Suivez-vous le tour de France cette année ?', 'answer_text' => 'Oui, c\'est toujours un spectacle à ne pas manquer !'],
            ['question' => 'Suivez-vous le tour de France cette année ?', 'answer_text' => 'Le Tour de France de cette année est particulièrement passionnant avec beaucoup de surprises.'],

            ['question' => 'MMA : match de Saint-Denis a vaincu son adversaire Marc Diakiese, qui a suivi ?', 'answer_text' => 'J\'ai trouvé le match très technique, Saint-Denis a dominé du début à la fin.'],

            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'answer_text' => 'C\'est une excellente continuation de l\'univers de GOT.'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'answer_text' => 'House of the Dragon commence bien, avec des intrigues captivantes et des personnages forts.'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'answer_text' => 'House of the Dragon commence bien, avec des intrigues captivantes et des personnages forts.'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'answer_text' => 'Les premiers épisodes sont prometteurs, avec une ambiance fidèle à l’univers de GOT.'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'answer_text' => 'Je trouve que la série a su maintenir l’héritage de Game of Thrones tout en apportant des nouveautés.'],
        ];

        foreach ($answers as $answerData) {
            $answer = new Answer();
            $answer->setAnswerText($answerData['answer_text']);

            // Trouver la question correspondante en se basant sur le titre
            $question = $manager->getRepository(Question::class)->findOneBy(['title' => $answerData['question']]);
            if ($question) {
                $answer->setQuestion($question);

                // Persister la réponse
                $manager->persist($answer);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            QuestionFixtures::class,
        ];
    }
}