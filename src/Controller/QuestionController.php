<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Category;
use App\Entity\User;
use App\Form\QuestionType;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/question')]
class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository, CategoryRepository $categoryRepository, UserRepository $userRepository, Request $request): Response
    {
        // Pagination
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $offset = ($page - 1) * $limit;
        // Récupérer le nombre total d'exercices
        $totalQuestions = $questionRepository->count([]);
        // Récupérer les exercices pour la page actuelle
        $questions = $questionRepository->findBy([], ['id' => 'DESC'], $limit, $offset);
        // Calculer le nombre total de pages
        $totalPages = ceil($totalQuestions / $limit);


        // Filtre
        // Récupérer les paramètres de recherche
        $title = $request->query->get('title');
        $author = $request->query->get('author');
        $category = $request->query->get('category');

        // Construire une requête personnalisée
        $queryBuilder = $questionRepository->createQueryBuilder('q')
            ->leftJoin('q.user', 'u')
            ->leftJoin('q.category', 'c')
            ->addSelect('u', 'c');

        if ($title) {
            $queryBuilder->andWhere('q.title LIKE :title')
                ->setParameter('title', '%' . $title . '%');
        }

        if ($author) {
            $queryBuilder->andWhere('u.id = :author')
                ->setParameter('author', $author);
        }

        if ($category) {
            $queryBuilder->andWhere('c.id = :category')
                ->setParameter('category', $category);
        }

        $questions = $queryBuilder->getQuery()->getResult();

        // Récupérer toutes les catégories pour le formulaire
        $categories = $categoryRepository->findAll();

        // Récupérer tous les auteurs (utilisateurs) pour le formulaire
        $authors = $userRepository->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            'categories' => $categories,
            'authors' => $authors,
            'questions' => $questions,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'now' => new \DateTime(),  // Ajouter la date actuelle
        ]);
    }

    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
