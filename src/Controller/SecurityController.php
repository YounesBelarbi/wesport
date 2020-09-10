<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use App\Form\PasswordUserType;
use App\Form\UserType;
use App\Service\SendMail;
use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('main');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }


    /**
     * @Route("/forgotten_password", name="app_forgotten_password")
     */
    public function forgottenPassword(Request $request, SendMail $sendMail, TokenService $TokenService): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('app_forgotten_password');
            }

            //check if user has token or generate and save token whith service : TokenService
            $token = $TokenService->token('reset password', $user);

            $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            //use service to send mail
            $sendMail->sendAnEmail(
                'Mot de passe oublié',
                $this->getParameter('app_email'),
                $user->getEmail(),
                "Pour réinitialiser votre mot de passe cliquez sur le lien : " . $url,
                'text/html'
            );

            $this->addFlash('success', 'Mail envoyé');
            return $this->redirectToRoute('main');
        }

        return $this->render('security/mail_user.html.twig', [
            'form' => $form->createView(),
            'pageTitle' => 'Mot de passe oublié',
            'title' => 'Mot de passe oublié',
            'description' => 'saisissez votre email pour recevoir le lien vous permettant de changer votre mot de passe'
        ]);
    }


    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userToken = $entityManager->getRepository(UserToken::class)->findOneBy(
            [
                'token' => $token, 'type' => 'reset password'
            ]
        );
        $currentDate = new \DateTime();


        if ($userToken === null || $userToken->getExpirationDate() < $currentDate) {
            $this->addFlash('danger', 'Un problème est survenu, votre mot de passe n\'a pas été modifié. Ce lien n\'est peut-être plus disponible.');
            return $this->redirectToRoute('main');
        }

        $form = $this->createForm(PasswordUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userToken->getUser();
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('newPassword')->getData()));
            $entityManager->remove($userToken);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe à bien été modifié');

            return $this->redirectToRoute('app_login');
        } else {

            return $this->render('security/reset_password.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
