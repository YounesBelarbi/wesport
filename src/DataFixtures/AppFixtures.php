<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


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

                //fill city and departement for users using the cities class
                $cityInformations = Cities::cityProvider();
                $entity->setCity($cityInformations['city']);
                $entity->setDepartement($cityInformations['admin_name']);
            }

            $em->persist($entity);
        };

        //enregistre
        $em->flush();
    }
}
