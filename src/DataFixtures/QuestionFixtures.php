<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des questions avec utilisateurs et catégories associées
        $questions = [
            [
                'title' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?',
                'publicationDate' => '13/08/2024',
                'image' => 'euroCup.svg',
                'user' => 'Jezmem',
                'category' => 'Sport',
            ],
            [
                'title' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ?',
                'publicationDate' => '13/08/2024',
                'image' => 'cs2VsValo.svg',
                'user' => 'TWhiteShadow',
                'category' => 'Technologie',
            ],
            [
                'title' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?',
                'publicationDate' => '13/08/2024',
                'image' => 'monteCristo.svg',
                'user' => 'Galeih',
                'category' => 'Cinéma',
            ],
            [
                'title' => 'Suivez-vous le tour de France cette année ?',
                'publicationDate' => '13/08/2024',
                'image' => 'franceTour.svg',
                'user' => 'Magiks',
                'category' => 'Sport',
            ],
            [
                'title' => 'MMA : match de Saint-Denis a vaincu son adversaire Marc Diakiese, qui a suivi ?',
                'publicationDate' => '13/08/2024',
                'image' => 'MMA.svg',
                'user' => 'Okinest',
                'category' => 'Sport',
            ],
            [
                'title' => 'Que pensez-vous de la série Game of thrones house of the dragon ?',
                'publicationDate' => '13/08/2024',
                'image' => 'got.svg',
                'user' => 'Yamosai',
                'category' => 'Cinéma',
            ],
        ];

        foreach ($questions as $questionData) {
            $question = new Question();
            $question->setTitle($questionData['title']);

            // Conversion de la chaîne de caractères en DateTime
            $publicationDate = \DateTime::createFromFormat('d/m/Y', $questionData['publicationDate']);
            $question->setPublicationDate($publicationDate);

            $question->setImage($questionData['image']);

            // Récupération de l'utilisateur
            $user = $manager->getRepository(User::class)->findOneBy(['username' => $questionData['user']]);
            if ($user) {
                $question->setUser($user);
            }

            // Récupération de la catégorie
            $category = $manager->getRepository(Category::class)->findOneBy(['name' => $questionData['category']]);
            if ($category) {
                $question->setCategory($category);
            }

            $manager->persist($question);
        }

        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['main_data'];
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
