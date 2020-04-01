<?php

namespace App\Controller;

use App\Entity\ContactList;
use App\Form\ContactListType;
use App\Repository\ContactListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="contact_list_")
 */
class ContactListController extends AbstractController
{
    /**
     * @Route("/contact_list", name="show")
     */
    public function showContactList(ContactListRepository $contactListRepository)
    {
        $contactList = $contactListRepository->ContactListOfUser($this->getUser());

        return $this->render('contact_list/index.html.twig', [
            'contactList' => $contactList,
        ]);
    }


    /**
     * @Route("/contact_list/add", name="creating")
     */
    public function addContactList(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $contactListForm = $this->createForm(ContactListType::class);
        $contactListForm->handleRequest($request);

        if ($contactListForm->isSubmitted() && $contactListForm->isValid()) {

            $contactList = new ContactList;

            $contactList->setName($contactListForm->get('name')->getData());
            $contactList->setCreator($user);
            $contactList->setCreatedAt(new \DateTime());

            $em->persist($contactList);
            $em->flush();
            $this->addFlash('success', 'votre liste à bien été créer');

            return $this->redirectToRoute('profile_show');
        }

        return $this->render('contact_list/contact_list.html.twig', [
            'contactListForm' => $contactListForm->createView(),
        ]);
    }


    /**
     * @Route("/contact_list/update/{id}", name="updating")
     */
    public function updateContactList(Request $request, $id, EntityManagerInterface $em, ContactList $contactList, ContactListRepository $contactListRepository)
    {
        $contactList = $contactListRepository->find($id);

        $contactListForm = $this->createForm(ContactListType::class, $contactList);
        $contactListForm->handleRequest($request);

        if ($contactListForm->isSubmitted() && $contactListForm->isValid()) {

            $em->flush();
            $this->addFlash('success', 'votre liste de contact à été mise à jour');
            return $this->redirectToRoute('profile_show');
        }

        return $this->render('contact_list/contact_list.html.twig', [
            'contactListForm' => $contactListForm->createView(),
        ]);
    }


    /**
     * @Route("/contact_list/delete/{id}", name="deleting")
     */
    public function deleteContactList(Request $request, $id, EntityManagerInterface $em, ContactList $contactList, ContactListRepository $contactListRepository)
    {
        $contactList = $contactListRepository->find($id);

        $em->remove($contactList);
        $em->flush();
        $this->addFlash('success', 'votre liste de contact à bien supprimée');
        return $this->redirectToRoute('profile_show');
    }
}
