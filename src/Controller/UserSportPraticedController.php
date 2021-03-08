<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Form\PraticedSportType;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/praticed-sport", name="sport_praticed_")
 */
class UserSportPraticedController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function addPracticedSport(Request $request, EntityManagerInterface $em, SportRepository $sportRepository )
    {
        $user = $this->getUser();
        $practicedSportForm = $this->createForm(PraticedSportType::class);
        $practicedSportForm->handleRequest($request);

        if ($practicedSportForm->isSubmitted() && $practicedSportForm->isValid()) {
            
            $sport = $practicedSportForm->get('name')->getData();    
            $user->addSportPraticed($sport);
            
            if ($sport != null) {
                try {
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success', 'Le sport est rajouté dans vos favoris');
                    return $this->redirectToRoute('profile_show');
                } catch (\Exception $e) {
                    $this->addFlash('warning', 'Ce sport fait déjà parti de votre liste de favori');
                }
            } 
        }

        return $this->render('sport_praticed_by_user/index.html.twig', [
            'practicedSportForm' => $practicedSportForm->createView(),
        ]);
    }



    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deletePracticedSport(Request $request, $id, EntityManagerInterface $em)
    {
        $sport = $em->getRepository(Sport::class)->findOneBy(['id' => $id]);
        $user = $this->getUser();
        $user->removeSportPraticed($sport);
        $em->flush();
        $this->addFlash('success', 'Les modifications ont bien été faites');
        return $this->redirectToRoute('profile_show');
    }
}
