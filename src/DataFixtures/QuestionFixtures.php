<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des auteurs
        $questions = [
            ['title' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'publicationDate' => '13/08/2024', 'image' => 'euroCup.jpg'],
            ['title' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ? ', 'publicationDate' => '13/08/2024', 'image' => 'cs2VsValo.jpg'],
            ['title' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'publicationDate' => '13/08/2024', 'image' => 'monteCristo.jpg'],
            ['title' => 'Suivez-vous le tour de France cette année ?', 'publicationDate' => '13/08/2024', 'image' => 'franceTour.jpg'],
            ['title' => 'MMA : match de Saint-Denis a vaincu son adversaire Marc Diakiese, qui a suivi ?', 'publicationDate' => '13/08/2024', 'image' => 'MMA.jpg'],
            ['title' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'publicationDate' => '13/08/2024', 'image' => 'GOT.jpg'],
        ];

        foreach ($questions as $questionData) {
            $question = new Question();
            $question->setTitle($questionData['title']);

            // Conversion de la chaîne de caractères en DateTime
            $publicationDate = \DateTime::createFromFormat('d/m/Y', $questionData['publicationDate']);
            $question->setPublicationDate($publicationDate);

            $question->setImage($questionData['image']);

            $manager->persist($question);
        }

        $manager->flush();
    }
}
