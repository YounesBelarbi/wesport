<?php

namespace App\Repository;

use App\Entity\FavoriteSport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FavoriteSport|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteSport|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteSport[]    findAll()
 * @method FavoriteSport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteSportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteSport::class);
    }

    // /**
    //  * @return FavoriteSport[] Returns an array of FavoriteSport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavoriteSport
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findUsersByAllInformations($criteria)
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->join('f.user', 'user');

        if (!is_null($criteria['age'])) {
            $qb
                ->where('user.age =:age')
                ->setParameter('age', $criteria['age']);
        }

        if (!is_null($criteria['city'])) {
            $qb
                ->andWhere('user.city =:city')
                ->setParameter('city', $criteria['city']);
        }


        if (!is_null($criteria['sport'])) {
            $qb
                ->andWhere('f.sport= :sport')
                ->setParameter('sport', $criteria['sport']);
        }


        return $qb
            ->getQuery()
            ->getResult();
    }
}
