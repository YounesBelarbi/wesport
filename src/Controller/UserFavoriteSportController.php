<?php

namespace App\Controller;

use App\Entity\FavoriteSport;
use App\Form\FavoriteSportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserFavoriteSportController extends AbstractController
{
    /**
     * @Route("/user/favorite/sport", name="user_favorite_sport")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        
        $user = $this->getUser();
    

        $favoriteSportForm = $this->createForm(FavoriteSportType::class);

        $favoriteSportForm->handleRequest($request);
       
        if ($favoriteSportForm->isSubmitted() && $favoriteSportForm->isValid()) {
            // dd($favoriteSportForm->get('level')->getData());
            $favoriteSport = new FavoriteSport;
            
            $favoriteSport->setLevel($favoriteSportForm->get('level')->getData());
           
            $favoriteSport->setUser($user);
            $favoriteSport->setSport($favoriteSportForm->get('sport')->getData());

            $em->persist($favoriteSport);
            $em->flush();
            $this->addFlash('success', 'Le sport est rajouté dans vos favoris');
        }

        return $this->render('user_favorite_sport/index.html.twig', [
            'favoriteSportForm' => $favoriteSportForm->createView(),
        ]);
    }
}
