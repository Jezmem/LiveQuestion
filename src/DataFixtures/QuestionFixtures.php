<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des questions avec utilisateurs et catégories associées
        $questions = [
            [
                'title' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?',
                'image' => 'euroCup.svg',
                'user' => 'Jezmem',
                'category' => 'Sport',
            ],
            [
                'title' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ?',
                'image' => 'cs2VsValo.svg',
                'user' => 'TWhiteShadow',
                'category' => 'Technologie',
            ],
            [
                'title' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?',
                'image' => 'monteCristo.svg',
                'user' => 'Galeih',
                'category' => 'Cinéma',
            ],
            [
                'title' => 'Suivez-vous le tour de France cette année ?',
                'image' => 'franceTour.svg',
                'user' => 'Magiks',
                'category' => 'Sport',
            ],
            [
                'title' => 'MMA : match de Saint-Denis a vaincu son adversaire Marc Diakiese, qui a suivi ?',
                'image' => 'MMA.svg',
                'user' => 'Okinest',
                'category' => 'Sport',
            ],
            [
                'title' => 'Que pensez-vous de la série Game of Thrones House of the Dragon ?',
                'image' => 'got.svg',
                'user' => 'Yamosai',
                'category' => 'Cinéma',
            ],
            [
                'title' => 'Quel est l’impact des nouvelles technologies sur l’éducation ?',
                'image' => 'tech_education.jpg',
                'user' => 'MentalWorker',
                'category' => 'Éducation',
            ],
            [
                'title' => 'Comment améliorer sa santé mentale grâce à la méditation ?',
                'image' => 'meditation_health.jpg',
                'user' => 'MentalWorker',
                'category' => 'Santé',
            ],
            [
                'title' => 'L’évolution du cinéma d’action depuis les années 80',
                'image' => 'action_cinema.jpg',
                'user' => 'Jezmem', 
                'category' => 'Cinéma',
            ],
            [
                'title' => 'Les enjeux du sport électronique en 2024',
                'image' => 'esports_2024.webp',
                'user' => 'Jezmem', 
                'category' => 'Sport',
            ],
            [
                'title' => 'L’impact de l’IA sur le marché du travail',
                'image' => 'ai_work.webp',
                'user' => 'Jezmem', 
                'category' => 'Technologie',
            ],
            [
                'title' => 'Le renouveau du cinéma français',
                'image' => 'french_cinema.jpeg',
                'user' => 'Magiks',
                'category' => 'Cinéma',
            ],
        ];

        foreach ($questions as $questionData) {
            $question = new Question();
            $question->setTitle($questionData['title']);

            $question->setPublicationDate(new \DateTime());

            $question->setImage($questionData['image']);

            $user = $manager->getRepository(User::class)->findOneBy(['username' => $questionData['user']]);
            if ($user) {
                $question->setUser($user);
            }

            $category = $manager->getRepository(Category::class)->findOneBy(['name' => $questionData['category']]);
            if ($category) {
                $question->setCategory($category);
            }

            $manager->persist($question);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
