<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\FavoriteSport;
use App\Entity\User;
use App\Form\SportResearchType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(EventRepository $eventRepository, EntityManagerInterface $em)
    {
        $lastEvent = $em->getRepository(Event::class)->lastEvents();
        $lastUserRegistred = $em->getRepository(User::class)->lastRegistred();
        $form = $this->createForm(SportResearchType::class);

        return $this->render('main/index.html.twig', [
            'lastEvent' => $lastEvent,
            'lastUserRegistred' => $lastUserRegistred,
            'form' => $form->createView(),
        ]);
    }
}
