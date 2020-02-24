<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Service\SendMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenGeneratorInterface $tokenGenerator, SendMail $sendMail): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            
            $ConfirmationToken = $tokenGenerator->generateToken();
            $user->setConfirmationToken($ConfirmationToken);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $url = $this->generateUrl('app_confirmation', array('token' => $ConfirmationToken), UrlGeneratorInterface::ABSOLUTE_URL);

            $sendMail->sendAnEmail('Confirmation de votre inscription', $this->getParameter('app_email'), $user->getEmail(),  "Pour activer votre compte et confirmer votre inscription cliquez sur le lien : " . $url,
            'text/html');

            $this->addFlash('success', 'Votre inscription a été enregistrée, vous aller recevoir un email de confirmation pour activer votre compte et pouvoir vous connecté');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    
    /**
    * @Route("/register/account_confirmation/{token}", name="app_confirmation")
    */
    public function accountConfirmation($token)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);
        
   
        if($user === null) {
            $this->addFlash('danger', 'Votre compte est déjà activé');
            return $this->redirectToRoute('app_login');
        }

        $user->setConfirmationToken(null);
        $user->setIsActive(true);

        $entityManager->flush($user);

        $this->addFlash('success', 'Votre compte est désormais actif, vous pouvez vous identifier.');
        return $this->redirectToRoute('app_login');

    }
    

    /**
    * @Route("/register/account/new_confirmation_mail", name="app_send_confirmation_token")
    */
    public function sendConfirmationToken(Request $request, SendMail $sendMail)
    {


        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        $email = $form->get('email')->getData();
    
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user === null) {
                
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('app_forgotten_password');

            } elseif ($user && $user->getConfirmationToken() != null) {
            
                $url = $this->generateUrl('app_confirmation', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
    
                $sendMail->sendAnEmail('Confirmation de votre inscription', $this->getParameter('app_email'), $user->getEmail(),  "Pour activer votre compte et confirmer votre inscription cliquez sur le lien : " . $url,
                'text/html');     
                $this->addFlash('success', 'Mail envoyé');

            } else{
                $this->addFlash('danger', 'Votre compte est déjà activé');
                return $this->redirectToRoute('app_login');
            } 
            
        }

        return $this->render('security/mail_user.html.twig', [
            'form' => $form->createView(),
            'pageTitle' => 'Mail de confirmation d\'inscription' ,
            'title' => 'Recevoir mon mail d\'activation de compte',
            'description' => 'saisissez votre email pour recevoir le lien d\'activation de votre compte'
        ]);



    }










}
