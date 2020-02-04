<?php

namespace App\Controller;

use App\Entity\FavoriteSport;
use App\Form\FavoriteSportType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserFavoriteSportController extends AbstractController
{

    /**
     * @Route("/user/addfavorite/sport", name="user_favorite_sport")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        
        $user = $this->getUser();
    

        $favoriteSportForm = $this->createForm(FavoriteSportType::class);

        $favoriteSportForm->handleRequest($request);
       
        if ($favoriteSportForm->isSubmitted() && $favoriteSportForm->isValid()) {
            
            $favoriteSport = new FavoriteSport;
            $level = $favoriteSportForm->get('level')->getData();
            $sport = $favoriteSportForm->get('sport')->getData();

            $favoriteSport->setLevel($level);
            $favoriteSport->setUser($user);
            $favoriteSport->setSport($sport);

            if ($sport != null && $level != null) {

                try {
                    
                    $em->persist($favoriteSport);
                    $em->flush();
                    $this->addFlash('success', 'Le sport est rajouté dans vos favoris');
        
                }catch (\Exception $e) {
                    
                    $this->addFlash('warning','Ce sport fait déjà parti de votre liste de favori'); 
                }
            } else {
                $this->addFlash('warning', 'renseigné tous les champs');
            }

        }

        return $this->render('user_favorite_sport/index.html.twig', [
            'favoriteSportForm' => $favoriteSportForm->createView(),
        ]);
    }
}
