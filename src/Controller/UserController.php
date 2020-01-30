<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('profileUser/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
    * @Route("/profile/edit", name="profile_edit")
    */
    public function editProfileUser(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //password processing
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            
            
            if (!empty(trim($newPassword)) && !empty($oldPassword)) {

                $checkOldPassword = $passwordEncoder->isPasswordValid($user, $oldPassword);
                
                if($checkOldPassword) {   

                        $user->setPassword(
                            $passwordEncoder->encodePassword(
                                $user,
                                $form->get('newPassword')->getData()
                            ));
                    }         
            }


            $em->flush();
            $this->addFlash('success', 'Votre profile à été mit à jour');
        }
            

        return $this->render('profileUser/update_profile.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
