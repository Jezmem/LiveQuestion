<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\QuestionRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function accueil(EntityManagerInterface $entityManager, QuestionRepository $questionRepository, UserRepository $userRepository): Response
    {
        // Récupérer la dernière question (ordre décroissant par date)
        $derniereQuestion = $entityManager->getRepository(Question::class)
            ->findOneBy([], ['publicationDate' => 'DESC']);

        // Récupérer les trois dernières questions
        $dernieresQuestions = $questionRepository->findBy([], ['publicationDate' => 'DESC'], 3);

        // Récupérer les cinq meilleurs auteurs (par nombre de questions publiées)
        $meilleursAuteurs = $userRepository->findTopAuthors(5);

        // Récupération des trois dernières questions de la catégorie "Sport"
        $sportQuestions = $questionRepository->findByCategoryWithLimit('Sport', 3);

        // Récupérer toutes les questions
        $allQuestions = $questionRepository->findAll();

        // Mélanger les questions
        shuffle($allQuestions);

        // Prendre un sous-ensemble de 5 questions
        $randomQuestions = array_slice($allQuestions, 0, 5);

        return $this->render('home/index.html.twig', [
            'derniere_question' => $derniereQuestion,
            'dernieres_questions' => $dernieresQuestions,
            'meilleurs_auteurs' => $meilleursAuteurs,
            'sportQuestions' => $sportQuestions,
            'randomQuestions' => $randomQuestions,
            'now' => new \DateTime(),  // Ajouter la date actuelle
        ]);
    }
}
