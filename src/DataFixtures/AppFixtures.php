<?php

namespace App\DataFixtures;

use App\Entity\ClassifiedAd;
use App\Entity\Event;
use App\Entity\FavoriteSport;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        $loader = new Loader();

        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__ . '/fixtures.yaml')->getObjects();

        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {

            if ($entity instanceof ClassifiedAd) {

                $entity->setAuthor($entity->getSeller()->getUsername());
            } elseif ($entity instanceof Event) {

                $entity->setAuthor($entity->getEventOrganizer()->getUsername());
            }

            if ($entity instanceof User) {

                if ($entity->getRoles() === ["ROLE_ADMIN", "ROLE_USER"]) {

                    $entity->setIsActive(true);
                }
            }

            $em->persist($entity);
        };

        //enregistre
        $em->flush();
    }
}
