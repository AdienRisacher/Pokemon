<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Entity\Dresseurs;
use App\Form\RegistrationFormType;
use App\Form\RegistrationType;
use App\Security\AppLoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class SecurityController extends AbstractController
{
    /**
     * Login action
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Redirect to profile if the user is already authenticated
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/connexion.html.twig' , ['last_username' => $lastUsername , 'error' => $error]);
    }

    /**
     * Registration action
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param AppLoginAuthenticator $authenticator
     * @param EntityManagerInterface $entityManager
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route(path:'/inscription', name: 'inscription')]
    public function registration(Request $request,  UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppLoginAuthenticator $authenticator, EntityManagerInterface $entityManager,AuthenticationUtils $authenticationUtils): Response
    {
        // Redirect to profile if the user is already authenticated
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        }

        $dresseur = new Dresseur();
        $form = $this->createForm(RegistrationType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dresseur->setPassword(
                $userPasswordHasher->hashPassword(
                    $dresseur,
                    $dresseur->getPassword()
                )
            );

            $dresseur->setCoins(5000);
            $dresseur->setType(1);
            $dresseur->setAvoirPremierPok(0);

            $entityManager->persist($dresseur);
            $entityManager->flush();
            return $userAuthenticator->authenticateUser(
                $dresseur,
                $authenticator,
                $request
            );
        }


        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Logout action
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
    }


}
