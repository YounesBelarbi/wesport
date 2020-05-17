<?php

namespace App\Controller;

use App\Entity\ClassifiedAd;
use App\Form\ClassifiedAdType;
use App\Repository\ClassifiedAdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassifiedAdController extends AbstractController
{
    /**
     * @Route("user/classified-ad/show", name="ad_list")
     */
    public function classifiedAdList(ClassifiedAdRepository $classifiedAdRepository)
    {
        $classifiedAdList = $classifiedAdRepository->findAll();
        return $this->render('classified_ad/classified_ad_list.html.twig', [
            'classifiedAdList' => $classifiedAdList,
            'user' =>  $this->getUser(),
        ]);
    }


    /**
     * @Route("/user/classified-ad/post-an-ad", name="ad_creating")
     */
    public function postAnAd(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $classifiedAdForm = $this->createForm(ClassifiedAdType::class);
        $classifiedAdForm->handleRequest($request);

        if ($classifiedAdForm->isSubmitted() && $classifiedAdForm->isValid()) {
            $classifiedAd = new ClassifiedAd;

            $classifiedAd->setClassifiedAdBody($classifiedAdForm->get('classifiedAdBody')->getData());
            $classifiedAd->setTitle($classifiedAdForm->get('title')->getData());
            $classifiedAd->setSportConcerned($classifiedAdForm->get('sportConcerned')->getData());
            $classifiedAd->setObjectForSale($classifiedAdForm->get('objectForSale')->getData());
            $classifiedAd->setPrice($classifiedAdForm->get('price')->getData());
            $classifiedAd->setAuthor($user->getUsername());
            $classifiedAd->setSeller($user);
            $classifiedAd->setCreatedAt(new \DateTime());

            try {
                $em->persist($classifiedAd);
                $em->flush();
                $this->addFlash('success', 'Votre annonce à bien été créer');
                return $this->redirectToRoute('profile_show');
            } catch (\Exception $e) {
                $this->addFlash('warning', 'Un problème est survenu, une information est manquante. Votre annonce n\'est pas enregistrée');
            }

            return $this->redirectToRoute('profile_show');
        }

        return $this->render('classified_ad/classified_ad.html.twig', [
            'classifiedAdForm' => $classifiedAdForm->createView(),
        ]);
    }


    /**
     * @Route("/user/classified-ad/update-an-ad/{slug}", name="ad_updating")
     */
    public function updateAnAd(
        Request $request,
        $slug,
        ClassifiedAdRepository $classifiedAdRepository,
        EntityManagerInterface $em,
        ClassifiedAd $classifiedAd
    ) {
        $classifiedAd = $classifiedAdRepository->findOneBy(['slug' => $slug]);
        $classifiedAdForm = $this->createForm(ClassifiedAdType::class, $classifiedAd);
        $classifiedAdForm->handleRequest($request);

        if ($classifiedAdForm->isSubmitted() && $classifiedAdForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Votre annonce à bien été mise à jour');
            return $this->redirectToRoute('profile_show');
        }

        return $this->render('classified_ad/classified_ad.html.twig', [
            'classifiedAdForm' => $classifiedAdForm->createView(),
        ]);
    }


    /**
     * @Route("/user/classified-ad/delete-an-ad/{id}", name="ad_deleting")
     */
    public function deleteAnAd(
        Request $request,
        $id,
        EntityManagerInterface $em,
        ClassifiedAdRepository $classifiedAdRepository
    ) {
        $classifiedAd = $classifiedAdRepository->find($id);

        $em->remove($classifiedAd);
        $em->flush();
        $this->addFlash('success', 'Votre annonce à bien été supprimée');

        return $this->redirectToRoute('profile_show');
    }
}
