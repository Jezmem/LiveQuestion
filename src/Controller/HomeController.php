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

    #[Route('/home', name: 'app_home_index')]
    public function accueil(EntityManagerInterface $entityManager, QuestionRepository $questionRepository, UserRepository $userRepository): Response
    {
        $derniereQuestion = $entityManager->getRepository(Question::class)
            ->findOneBy([], ['publicationDate' => 'DESC']);

        $dernieresQuestions = $questionRepository->findBy([], ['publicationDate' => 'DESC'], 3);

        $meilleursAuteurs = $userRepository->findTopAuthors(5);

        $sportQuestions = $questionRepository->findByCategoryWithLimit('Sport', 3);

        $allQuestions = $questionRepository->findAll();

        shuffle($allQuestions);

        $randomQuestions = array_slice($allQuestions, 0, 5);


        return $this->render('home/index.html.twig', [
            'derniere_question' => $derniereQuestion,
            'dernieres_questions' => $dernieresQuestions,
            'meilleurs_auteurs' => $meilleursAuteurs,
            'sportQuestions' => $sportQuestions,
            'randomQuestions' => $randomQuestions,
            'now' => new \DateTime(), 
        ]);
    }
}
