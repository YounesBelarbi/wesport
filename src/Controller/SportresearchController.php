<?php

namespace App\Controller;

use App\Entity\FavoriteSport;
use App\Entity\Level;
use App\Entity\Sport;
use App\Entity\User;
use App\Form\SportResearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class SportresearchController extends AbstractController
{
    /**
     * @Route("/user/sportresearch", name="sportresearch")
     */
    public function index(Request $request,EntityManagerInterface $em)
    {
        //récuperer par ville:
        // $em->getRepository(User::class)->findBy(['city' => $city]);

        //récuperer par le sport:
        // $theSport = $em->getRepository(Sport::class)->findOneBy(['name' => $sport]);
        // dump($em->getRepository(FavoriteSport::class)->findUsersBySport($theSport));

        // récuperer par le level :
        // $theLevel = $em->getRepository(Level::class)->findOneBy(['name' => $level]);
        // dump($em->getRepository(FavoriteSport::class)->findUsersByLevel($theLevel));
    

        $form = $this->createForm(SportResearchType::class);
        $form->handleRequest($request);
    
        return $this->render('sportresearch/index.html.twig', [
            'form' => $form->createView(),
            ]);
    }
        
             
             
    /**
     * @Route("/user/sportresearch/requete", name="sportresearch_requete")
     */
    public function ajaxResponse(Request $request, EntityManagerInterface $em)
    {
           
        if($request->isXmlHttpRequest()){
            
            $city = $request->request->get('city');
            $age = $request->request->get('age');
            $sport = $request->request->get('sport');
            $level = $request->request->get('level');


             // recupéré les user avec l'age:
            $users = $em->getRepository(User::class)->findBy(['age' => $age]);

            //normalize information
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
            $normalizer = new ObjectNormalizer($classMetadataFactory);
            $serializer = new Serializer([$normalizer]);

            $data = $serializer->normalize($users, null, ['groups' => 'searchResult']);

            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
                
            return $response;

        }
        
        return $this->json([
            '$errors '=>'requête invalide'
        ], 400);
                
    }
}
