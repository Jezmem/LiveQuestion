<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AccountType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class AccountController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/my-account', name: 'app_my_account')]
    public function myAccount(
        Request $request,
        EntityManagerInterface $entityManager,
        QuestionRepository $questionRepository
    ): Response {
        $user = $this->security->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
            return $this->redirectToRoute('app_my_account');
        }

        $userQuestions = $questionRepository->findBy(['user' => $user], ['publicationDate' => 'DESC']);

        return $this->render('account/my-account.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'userQuestions' => $userQuestions,
        ]);
    }
}
