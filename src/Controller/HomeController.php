<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function accueil(EntityManagerInterface $entityManager, QuestionRepository $questionRepository): Response
    {
        // Récupérer la dernière question (ordre décroissant par date)
        $derniereQuestion = $entityManager->getRepository(Question::class)
            ->findOneBy([], ['publicationDate' => 'DESC']);

        // Récupérer les trois dernières questions
        $dernieresQuestions = $questionRepository->findBy([], ['publicationDate' => 'DESC'], 3);

        // Récupérer la catégorie "Sport"
        $categorieSport = $entityManager->getRepository(Category::class)
            ->findOneBy(['name' => 'Sport']);

        // Récupérer les 3 dernières questions ayant pour catégorie "Sport"
        $troisDernieresQuestionsSport = $entityManager->getRepository(Question::class)
            ->findBy(['category' => $categorieSport], ['publicationDate' => 'DESC'], 3);

        // Récupérer une question aléatoire
        $nombreDeQuestions = $entityManager->getRepository(Question::class)
            ->count([]);
        $questionAleatoire = null;
        if ($nombreDeQuestions > 0) {
            $offset = rand(0, $nombreDeQuestions - 1);
            $questionAleatoire = $entityManager->getRepository(Question::class)
                ->findBy([], null, 1, $offset);
        }

        return $this->render('home/index.html.twig', [
            'derniere_question' => $derniereQuestion,
            'now' => new \DateTime(),  // Ajouter la date actuelle
            'dernieres_questions' => $dernieresQuestions,
            'trois_derniers_questions_sport' => $troisDernieresQuestionsSport,
            'question_aleatoire' => $questionAleatoire[0] ?? null,
        ]);
    }
}
