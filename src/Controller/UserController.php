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

        return $this->render('profileUser/update_profile.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
