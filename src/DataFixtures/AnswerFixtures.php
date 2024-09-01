<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $answers = [
            ['question' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'content' => 'Oui, ils ont fait un excellent parcours jusqu\'à présent.', 'user' => 'Jezmem'],
            ['question' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'content' => 'La France a montré de grandes performances, surtout en défense.', 'user' => 'TWhiteShadow'],
            ['question' => 'Est-ce que la France est à la hauteur sur cette coupe d’Euro ?', 'content' => 'La France a montré de grandes performances, surtout en défense.', 'user' => 'Galeih'],

            ['question' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ?', 'content' => 'Je préfère CS2 pour son gameplay classique, mais Valorant a ses avantages.', 'user' => 'Magiks'],
            ['question' => 'CS2 vs Valorant, quel jeu est le meilleur au quotidien ?', 'content' => 'Valorant a un côté stratégique plus prononcé, mais CS2 reste un classique indémodable.', 'user' => 'Okinest'],

            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'content' => 'Sa performance était exceptionnelle, il a vraiment incarné le personnage.', 'user' => 'Yamosai'],
            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'content' => 'Pierre Niney a vraiment su capturer l\'essence du personnage, une performance incroyable.', 'user' => 'Jezmem'],
            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'content' => 'Pierre Niney a vraiment su capturer l\'essence du personnage, une performance incroyable.', 'user' => 'TWhiteShadow'],
            ['question' => 'Que pensez-vous de la performance de Pierre Niney dans le comte de Monte Cristo ?', 'content' => 'Je pense qu’il a réussi à rendre justice au personnage d’une manière impressionnante.', 'user' => 'Galeih'],

            ['question' => 'Suivez-vous le tour de France cette année ?', 'content' => 'Oui, c\'est toujours un spectacle à ne pas manquer !', 'user' => 'Magiks'],
            ['question' => 'Suivez-vous le tour de France cette année ?', 'content' => 'Le Tour de France de cette année est particulièrement passionnant avec beaucoup de surprises.', 'user' => 'Okinest'],

            ['question' => 'MMA : match de Saint-Denis a vaincu son adversaire Marc Diakiese, qui a suivi ?', 'content' => 'J\'ai trouvé le match très technique, Saint-Denis a dominé du début à la fin.', 'user' => 'Yamosai'],

            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'content' => 'C\'est une excellente continuation de l\'univers de GOT.', 'user' => 'Jezmem'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'content' => 'House of the Dragon commence bien, avec des intrigues captivantes et des personnages forts.', 'user' => 'TWhiteShadow'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'content' => 'House of the Dragon commence bien, avec des intrigues captivantes et des personnages forts.', 'user' => 'Galeih'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'content' => 'Les premiers épisodes sont prometteurs, avec une ambiance fidèle à l’univers de GOT.', 'user' => 'Magiks'],
            ['question' => 'Que pensez-vous de la série Game of thrones house of the dragon ?', 'content' => 'Je trouve que la série a su maintenir l’héritage de Game of Thrones tout en apportant des nouveautés.', 'user' => 'Okinest'],

            ['question' => 'Quel est l’impact des nouvelles technologies sur l’éducation ?', 'content' => 'Les nouvelles technologies permettent une meilleure accessibilité aux ressources éducatives.', 'user' => 'Jezmem'],
            ['question' => 'Quel est l’impact des nouvelles technologies sur l’éducation ?', 'content' => 'Elles ont révolutionné l’enseignement, rendant l’apprentissage plus interactif et dynamique.', 'user' => 'MentalWorker'],
            ['question' => 'Comment améliorer sa santé mentale grâce à la méditation ?', 'content' => 'La méditation aide à réduire le stress et à améliorer la concentration.', 'user' => 'MentalWorker'],
            ['question' => 'Comment améliorer sa santé mentale grâce à la méditation ?', 'content' => 'Je médite chaque jour, et cela a grandement amélioré mon bien-être.', 'user' => 'Magiks'],
            ['question' => 'L’évolution du cinéma d’action depuis les années 80', 'content' => 'Le cinéma d’action a évolué avec plus de technologie et des scènes plus intenses.', 'user' => 'Jezmem'],
            ['question' => 'Les enjeux du sport électronique en 2024', 'content' => 'Les compétitions e-sport sont de plus en plus populaires, avec des enjeux financiers énormes.', 'user' => 'Okinest'],
            ['question' => 'L’impact de l’IA sur le marché du travail', 'content' => 'L’IA pourrait transformer de nombreux métiers, mais elle offre aussi des opportunités.', 'user' => 'MentalWorker'],
            ['question' => 'Le renouveau du cinéma français', 'content' => 'Le cinéma français connaît un regain d’intérêt, avec des films innovants et créatifs.', 'user' => 'Magiks'],
        ];

        foreach ($answers as $answerData) {
            $answer = new Answer();
            $answer->setContent($answerData['content']);

            $question = $manager->getRepository(Question::class)->findOneBy(['title' => $answerData['question']]);
            $user = $manager->getRepository(User::class)->findOneBy(['username' => $answerData['user']]);
            
            if ($question && $user) {
                $answer->setQuestion($question);
                $answer->setUser($user);

                $randomDate = new \DateTimeImmutable(sprintf('-%d days', rand(0, 365)));
                $answer->setCreatedAt($randomDate);

                $manager->persist($answer);
            }
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['second_load'];
    }

    public function getDependencies()
    {
        return [
            QuestionFixtures::class,
            UserFixtures::class,
        ];
    }
}
