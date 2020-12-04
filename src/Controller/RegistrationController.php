<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\RegistrationType;
use App\Form\RegistrationFormType;
use App\Security\CustomerAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * Permet d'afficher le formulaire d'inscription
     * 
     * @Route("/register", name="customer_register")
     * 
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $user = new Customer();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        // dd($form->handleRequest($request));
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );
            $user->setRoles("ROLE_USER");

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                "success",
                "Votre compte a bien été crée"
            );

            return $this->redirectToRoute('customer_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
