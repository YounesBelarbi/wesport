<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="event_")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/event", name="list")
     */
    public function eventShow(Request $request, EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $allEvent = $eventRepository->findAll();

        return $this->render(
            'event/event_list.html.twig',
            [
                'eventList' => $allEvent,
                'user' =>  $this->getUser(),
            ]
        );
    }


    /**
     * @Route("/event/add", name="organized")
     */
    public function eventOrganization(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $eventOrganizationForm = $this->createForm(EventType::class);
        $eventOrganizationForm->handleRequest($request);

        if ($eventOrganizationForm->isSubmitted() && $eventOrganizationForm->isValid()) {
            $event = new Event;

            $event->setEventOrganizer($user);
            $event->setAuthor($user->getUsername());
            $event->setEventBody($eventOrganizationForm->get('eventBody')->getData());
            $event->setSportConcerned($eventOrganizationForm->get('sportConcerned')->getData());
            $event->setTitle($eventOrganizationForm->get('title')->getData());
            $event->setLocation($eventOrganizationForm->get('location')->getData());
            $event->setCreatedAt(new \DateTime());

            $eventDate = $eventOrganizationForm->get('eventDate')->getData();

            //ckeck if event date comes after current date
            if ($eventDate > new \DateTime()) {
                $event->setEventDate($eventDate);
            }

            try {
                $em->persist($event);
                $em->flush();
                $this->addFlash('success', 'Votre événement est créer');
                return $this->redirectToRoute('profile_show');
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Un problème est survenu, une information est manquante. Votre événement n\'est pas enregistré');
            }

            return $this->redirectToRoute('profile_show');
        }

        return $this->render('event/event.html.twig', [
            'eventForm' => $eventOrganizationForm->createView(),
        ]);
    }


    /**
     * @Route("/event/update/{slug}", name="edit")
     */
    public function eventEdit(
        Request $request,
        EntityManagerInterface $em,
        EventRepository $eventRepository,
        Event $event
    ) {
        $eventEditForm = $this->createForm(EventType::class, $event);
        $eventEditForm->handleRequest($request);

        if ($eventEditForm->isSubmitted() && $eventEditForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'l\'événement à été mit à jour');
            // return $this->redirectToRoute('profile_show');
        }

        return $this->render('event/event.html.twig', [
            'eventForm' => $eventEditForm->createView(),
        ]);
    }


    /**
     * @Route("/event/delete/{id}", name="deletion")
     */
    public function eventDeletion($id, EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $event = $eventRepository->find($id);
        $em->remove($event);
        $em->flush();
        $this->addFlash('success', 'l\'evenement ' . $event->getTitle() . ' à bien été suppimé');

        return $this->redirectToRoute('profile_show');
    }


    /**
     * @Route("/event/registration/{id}", name="participation")
     */
    public function eventParticipation($id, EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $user = $this->getUser();
        $event = $eventRepository->find($id);
        $event->addParticipatingUserList($user);
        $em->flush();
        $this->addFlash('success', 'Vous êtes inscrit à l\'evenement ' . $event->getTitle());

        return $this->redirectToRoute('event_list');
    }


    /**
     * @Route("/event/deregistration/{id}", name="deregistration")
     */
    public function eventDeregistration($id, EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $user = $this->getUser();
        $event = $eventRepository->find($id);
        $event->removeParticipatingUserList($user);
        $em->flush();
        $this->addFlash('warning', 'Vous n\'êtes plus inscrit à l\'evenement ' . $event->getTitle());

        return $this->redirectToRoute('event_list');
    }
}
