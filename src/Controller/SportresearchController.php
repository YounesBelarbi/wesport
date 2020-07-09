<?php

namespace App\Controller;

use App\Entity\FavoriteSport;
use App\Repository\LevelRepository;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;



class SportresearchController extends AbstractController
{
    /**
     * @Route("/user/sportresearch", name="sportresearch")
     */
    public function index(
        Request $request,
        EntityManagerInterface $em,
        SportRepository $sportRepository,
        LevelRepository $levelRepository
    ) {
        $requestContent = json_decode($request->getContent(), true);
        $users = [];
        $userSportList = [];
        $criteria = [];
        $criteria['sport'] = $sportRepository->findOneBy(['name' => $requestContent['sport']]);
        $criteria['level'] = $levelRepository->findOneBy(['name' => $requestContent['level']]);
        $criteria['age'] = null;
        $criteria['city'] = null;


        if (!is_null($criteria['sport']) || !is_null($criteria['level'])) {
            $userSportList = $em->getRepository(FavoriteSport::class)->findUsersByAllInformations($criteria);
        }

        foreach ($userSportList as $key => $value) {
            $users[] = $value->getUser();
        }

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' => 'searchResult']);

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
