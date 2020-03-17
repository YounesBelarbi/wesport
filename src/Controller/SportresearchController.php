<?php

namespace App\Controller;

use App\Entity\FavoriteSport;
use App\Form\SportResearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SportresearchController extends AbstractController
{
    /**
     * @Route("/user/sportresearch", name="sportresearch")
     */
    public function index(Request $request,EntityManagerInterface $em)
    {
        
        $userSportList =[];
        $users=[];

        $form = $this->createForm(SportResearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $criteria = $form->getData();

            if (!is_null($criteria['age']) || !is_null($criteria['city']) || !is_null($criteria['sport']) || !is_null($criteria['level'])) {
                
                $userSportList = $em->getRepository(FavoriteSport::class)->findUsersByAllInformations($criteria);
            }
          dump($userSportList);

        }

        foreach ($userSportList as $key => $value) {
            $users[] = $value->getUser();
        }

        return $this->render('sportresearch/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users
            ]);
    }
        
}
