<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MailResetPasswordType;
use App\Form\ResetPasswordType;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
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
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {

            $form = $this->createForm(MailResetPasswordType::class);
            $form->handleRequest($request);

            $email = $form->get('email')->getData();
        
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $entityManager = $this->getDoctrine()->getManager();
                $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
                
                if ($user === null) {
                    $this->addFlash('danger', 'Email Inconnu');
                    return $this->redirectToRoute('app_forgotten_password');
                }
                $token = $tokenGenerator->generateToken();

                try{
                    $user->setResetToken($token);
                    $entityManager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
                    return $this->redirectToRoute('main');
                }

                $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
                
                
                $message = (new \Swift_Message('Forgot Password'))
                    ->setFrom('wesport.w@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        "blablabla voici le token pour reseter votre mot de passe : " . $url,
                        'text/html'
                    );

                $mailer->send($message);

                $this->addFlash('success', 'Mail envoyé');

                return $this->redirectToRoute('main');
            }
        

        return $this->render('security/forgotten_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {


        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);
            

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('main');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('newPassword')->getData()));
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe à bien été modifié');

            return $this->redirectToRoute('app_login');
        }else {

            return $this->render('security/reset_password.html.twig',  [
                'form' => $form->createView(),
            ]);
        }

    }


}
