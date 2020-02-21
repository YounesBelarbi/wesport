<?php

namespace App\Controller;

use App\Entity\ClassifiedAd;
use App\Entity\Event;
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
      $lastClassifiedAds = $em->getRepository((ClassifiedAd::class))->lastClassifiedAds();

        return $this->render('main/index.html.twig', [
          'lastEvent' => $lastEvent,
          'lastClassifiedAds' => $lastClassifiedAds,
        ]);
    }
}
