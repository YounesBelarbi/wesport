<?php

namespace App\Controller;

use App\Form\PasswordUserType;
use App\Form\UserType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profile", name="profile_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('profileUser/index.html.twig', [
            'user' => $user
        ]);
    }


    /**
     * @Route("/edit", name="edit")
     */
    public function editProfileUser(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, FileUploader $fileUploader)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileImage = $form->get('profileImage')->getData();
                        
            if ($profileImage) {
                $fileUploader->deleteOldFile($user);
                $profileImageFileName = $fileUploader->upload($profileImage);
                $user->setProfileImage($profileImageFileName);
            }

            $em->flush();
            $this->addFlash('success', 'Votre profile à été mit à jour');
            return $this->redirectToRoute('profile_show');
        }

        return $this->render('profileUser/update_profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit/password", name="edit_password")
     */
    public function userPasswordReset(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //password processing
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();

            if (!empty(trim($newPassword)) && !empty($oldPassword)) {

                $checkOldPassword = $passwordEncoder->isPasswordValid($user, $oldPassword);

                if ($checkOldPassword) {

                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $form->get('newPassword')->getData()
                        )
                    );

                    $em->flush();
                    $this->addFlash('success', 'Votre mot de passe à été changer');
                    return $this->redirectToRoute('profile_show');
                } else {
                    $this->addFlash('warning', 'Le mot de passe saisi est erroné');
                }
            }
        }

        return $this->render('profileUser/password_change.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
