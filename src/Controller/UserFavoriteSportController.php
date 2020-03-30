<?php

namespace App\Controller;

use App\Entity\FavoriteSport;
use App\Entity\Sport;
use App\Form\FavoriteSportType;
use App\Repository\FavoriteSportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_favorite_")
 */
class UserFavoriteSportController extends AbstractController
{
    /**
     * @Route("/listfavorite/sport", name="sport_list")
     */
    public function userFavoriteSportList(FavoriteSportRepository $favoriteSportRepository)
    {
        $userFavoriteSportList = $favoriteSportRepository->findBy(['user' => $this->getUser()]);

        return $this->render('user_favorite_sport/user_favorite_sport_list.html.twig', [
            'userFavoriteSportList' => $userFavoriteSportList
        ]);
    }


    /**
     * @Route("/addfavorite/sport", name="sport_add")
     */
    public function addFavoriteSport(Request $request, EntityManagerInterface $em)
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
                    return $this->redirectToRoute('profile_edit');
                } catch (\Exception $e) {

                    $this->addFlash('warning', 'Ce sport fait déjà parti de votre liste de favori');
                }
            } else {
                $this->addFlash('warning', 'renseigné tous les champs');
            }
        }

        return $this->render('user_favorite_sport/favorite_sport.html.twig', [
            'favoriteSportForm' => $favoriteSportForm->createView(),
        ]);
    }


    /**
     * @Route("/updatefavorite/sport/{id}", name="sport_update")
     */
    public function updateFavoriteSport(Request $request, $id, EntityManagerInterface $em)
    {
        $sport = $em->getRepository(Sport::class)->findOneBy(['id' => $id]);
        $user = $this->getUser();
        $myFavoriteSport = $em->getRepository(FavoriteSport::class)->find(['sport' => $sport, 'user' => $user]);

        $favoriteSportForm = $this->createForm(FavoriteSportType::class, $myFavoriteSport);
        $favoriteSportForm->handleRequest($request);

        if ($favoriteSportForm->isSubmitted() && $favoriteSportForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'Les modifications ont bien été faites');
            return $this->redirectToRoute('user_favorite_sport_list');
        }

        return $this->render('user_favorite_sport/favorite_sport.html.twig', [
            'favoriteSportForm' => $favoriteSportForm->createView(),
        ]);
    }


    /**
     * @Route("/deletefavorite/sport/{id}", name="sport_delete")
     */
    public function deleteFavoriteSport(Request $request, $id, EntityManagerInterface $em)
    {
        $sport = $em->getRepository(Sport::class)->findOneBy(['id' => $id]);
        $user = $this->getUser();
        $myFavoriteSport = $em->getRepository(FavoriteSport::class)->find(['sport' => $sport, 'user' => $user]);

        $em->remove($myFavoriteSport);
        $em->flush();
        $this->addFlash('success', 'Les modifications ont bien été faites');
        return $this->redirectToRoute('user_favorite_sport_list');
    }
}
