<?php

namespace App\DataFixtures;

use App\Entity\ClassifiedAd;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        // $product = new Product();
        // $manager->persist($product);

        $loader = new Loader();
        
        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__.'/fixtures.yaml')->getObjects();
        
        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {

            if ($entity instanceof ClassifiedAd ) {

                $entity->setAuthor($entity->getSeller()->getUsername());

            } elseif ($entity instanceof Event) {
                $entity->setAuthor($entity->getEventOrganizer()->getUsername());
            }

            $em->persist($entity);
        };
        
        //enregistre
        $em->flush();

        
    }
}
