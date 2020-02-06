<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventOrganizationType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{

     /**
     * @Route("/user/event/show", name="event_list")
     */
    public function eventShow(Request $request, EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $allEvent = $eventRepository->findAll();


        return $this->render('event/event_list.html.twig', [
            'eventList' => $allEvent,
        ]);

    }





    /**
     * @Route("/user/event/organization", name="event_organized")
     */
    public function eventOrganization(Request $request, EntityManagerInterface $em)
    {

        $user = $this->getUser();
    
       
        $eventOrganizationForm = $this->createForm(EventOrganizationType::class);

        $eventOrganizationForm->handleRequest($request);
       
        if ($eventOrganizationForm->isSubmitted() && $eventOrganizationForm->isValid()) {
    
            $event = New Event;

            $event->setEventOrganizer($user);
            $event->setAuthor($user->getUsername());

            $event->setEventBody($eventOrganizationForm->get('eventBody')->getData());
            $event->setSportConcerned($eventOrganizationForm->get('sportConcerned')->getData());
            $event->setTitle($eventOrganizationForm->get('title')->getData());
            $event->setLocation($eventOrganizationForm->get('location')->getData());
            $event->setEventDate($eventOrganizationForm->get('eventDate')->getData());
            $event->setCreatedAt(new \DateTime());
            

            try {
                    
                $em->persist($event);
                $em->flush();
                $this->addFlash('success', 'Votre événement est créer');
                return $this->redirectToRoute('profile_edit');
    
            }catch (\Exception $e) {
                
                $this->addFlash('warning','Un problème est survenu, une information est manquante. Votre événement n\'est pas enregistré'); 
            }

            return $this->redirectToRoute('profile_edit');

        }

        return $this->render('event/event_organization.html.twig', [
            'eventOrganizationForm' => $eventOrganizationForm->createView(),
        ]);
    }


    /**
     * @Route("/user/event/participation/{id}", name="event_participation")
     */
    public function eventParticipation($id, EntityManagerInterface $em, EventRepository $eventRepository)
    {

        $user = $this->getUser();
        $event = $eventRepository->find($id);
        $event->addParticipatingUserList($user);
        $em->flush();
        $this->addFlash('success', 'Vous êtes inscrit à l\'evenement '.$event->getTitle());
        return $this->redirectToRoute('event_list');
      
        // $eventParticipationForm = $this->createForm(EventOrganizationType::class);

        // $eventParticipationForm->handleRequest($request);
       
        // if ($eventParticipationForm->isSubmitted() && $eventParticipationForm->isValid()) {

           

        // }

        // return $this->render('event/event_participation.html.twig', [

        //     'eventParticipationForm' => $eventParticipationForm->createView(),
        // ]);
    }
}
