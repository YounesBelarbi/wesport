<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventOrganisationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{


    /**
     * @Route("/user/event/organisation", name="event_organized")
     */
    public function eventOrganisation(Request $request, EntityManagerInterface $em)
    {

        $user = $this->getUser();
    
       
        $eventOrganisationForm = $this->createForm(EventOrganisationType::class);

        $eventOrganisationForm->handleRequest($request);
       
        if ($eventOrganisationForm->isSubmitted() && $eventOrganisationForm->isValid()) {
    
            $event = New Event;

            $event->setEventOrganizer($user);
            $event->setAuthor($user->getUsername());

            $event->setEventBody($eventOrganisationForm->get('eventBody')->getData());
            $event->setSportConcerned($eventOrganisationForm->get('sportConcerned')->getData());
            $event->setTitle($eventOrganisationForm->get('title')->getData());
            $event->setLocation($eventOrganisationForm->get('location')->getData());
            $event->setEventDate($eventOrganisationForm->get('eventDate')->getData());
            $event->setCreatedAt(new \DateTime());
            

            try {
                    
                $em->persist($event);
                $em->flush();
                $this->addFlash('success', 'Votre événement est créer');
                return $this->redirectToRoute('profile_edit');
    
            }catch (\Exception $e) {
                
                $this->addFlash('warning','Un probème est survenue, une information est manquante. Votre événement n\'est pas enregistré'); 
            }

            return $this->redirectToRoute('edit');

        }

        return $this->render('event/index.html.twig', [
            'eventOrganisationForm' => $eventOrganisationForm->createView(),
        ]);
    }
}
