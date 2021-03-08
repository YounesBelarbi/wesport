<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SportRepository;;
use App\Service\RequestCity;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class SportresearchController extends AbstractController
{
    /**
     * @Route("/sportresearch", name="sportresearch")
     */
    public function index(
        Request $request,
        EntityManagerInterface $em,
        SportRepository $sportRepository
    ) {
        $response = new Response();

        if (!$this->getUser()) {  
            $response->setContent(json_encode(['error' => 'unidentified user']));
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->headers->set('content-type', 'application/json');
            return $response;
        }                  

        $requestContent = json_decode($request->getContent(), true);
        $users = [];
        $criteria = [];
        $criteria['city'] =  $requestContent['city']; 
        $criteria['sport'] = $sportRepository->findOneBy(['name' => $requestContent['sport']]);
        $users= $em->getRepository(User::class)->findUsers($criteria);

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $data = $serializer->normalize($users, null, ['groups' => 'searchResult']);
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');   
   
        return $response;
    }

    /**
    * @Route("/sportresearch/get-city-list", name="cityPerDepartement")
    */
    public function cityforDepartement(Request $request, RequestCity $requestCityService)
    {
        $requestContent = json_decode($request->getContent(), true);
        $cityList = $requestCityService->getCity($requestContent['departmentCode']);
        $response = new Response();
        $response->setContent(json_encode(['cityList' => $cityList]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
