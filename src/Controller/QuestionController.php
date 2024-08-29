<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Answer;
use App\Form\QuestionType;
use App\Form\AnswerType;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[Route('/question')]
class QuestionController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository, CategoryRepository $categoryRepository, UserRepository $userRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $totalQuestions = $questionRepository->count([]);

        $questions = $questionRepository->findBy([], ['id' => 'DESC'], $limit, $offset);

        $totalQuestions = count($questions);


        $totalPages = ceil($totalQuestions / $limit);

        $categories = $categoryRepository->findAll();

        $authors = $userRepository->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            'categories' => $categories,
            'authors' => $authors,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'now' => new \DateTime(),  // Ajouter la date actuelle
        ]);
    }

    #[Route('/new', name: 'app_question_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $this->tokenStorage->getToken()->getUser();
            $question->setUser($user);

            // Gestion de l'image uploadée
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gestion des erreurs lors du déplacement du fichier
                }

                // Stocker le nom de l'image dans l'entité
                $question->setImage($newFilename);
            }

            // Définir la date de publication à la date actuelle
            $question->setPublicationDate(new \DateTime());

            // Enregistrer la question
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_question_index');
        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/myquestions', name: 'app_my_questions')]
    public function myQuestions(QuestionRepository $questionRepository, UserInterface $user): Response
    {
        // Récupérer les questions de l'utilisateur connecté
        $questions = $questionRepository->findBy(['user' => $user]);

        return $this->render('question/my-questions.html.twig', [
            'questions' => $questions,
        ]);
    }


    #[Route('/edit/{id}', name: 'app_question_edit')]
    public function edit(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur connecté est l'auteur de la question
        if ($question->getUser() !== $this->tokenStorage->getToken()->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette question.');
        }

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_question_index');
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_question_delete')]
    public function delete(Question $question, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur connecté est l'auteur de la question
        if ($question->getUser() !== $this->tokenStorage->getToken()->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette question.');
        }

        $entityManager->remove($question);
        $entityManager->flush();

        return $this->redirectToRoute('app_question_index');
    }


    #[Route('/{id}', name: 'app_question_show')]
    public function show(Question $question, Request $request, EntityManagerInterface $em): Response
    {
        if (!$question) {
            throw $this->createNotFoundException('La question n\'existe pas.');
        }
        $answer = new Answer();
        // Définir la date de publication à la date actuelle
        $answer->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setQuestion($question);
            $answer->setUser($this->getUser()); // Assurez-vous que l'utilisateur est connecté
            // $answer->setPublicationDate(new \DateTime());

            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('app_question_show', ['id' => $question->getId()]);
        }

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }
}
