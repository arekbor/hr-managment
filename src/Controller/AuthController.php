<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/auth')]
class AuthController extends AbstractController
{
    #[Route('/login')]
    public function login(): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        return $this->render('auth/login.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/register')]
    public function register(
        Request $request, 
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $hasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );

            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_auth_login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form
        ]);
    }
}
