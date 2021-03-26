<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        $loader = new Loader();

        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__ . '/fixtures.yaml')->getObjects();

        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {

            if ($entity instanceof Event) {

                $entity->setAuthor($entity->getEventOrganizer()->getUsername());
            }

            if ($entity instanceof User) {

                if ($entity->getRoles() === ["ROLE_ADMIN", "ROLE_USER"]) {

                    $entity->setIsActive(true);
                }

                //fill city for users using the cities class
                $cityInformations = Cities::cityProvider();
                $entity->setCity($cityInformations['city']);
            }

            $em->persist($entity);
        };

        //enregistre
        $em->flush();
    }
}
