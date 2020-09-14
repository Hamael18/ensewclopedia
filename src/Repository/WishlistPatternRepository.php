<?php

namespace App\Repository;

use App\Entity\WishlistPattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WishlistPattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishlistPattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishlistPattern[]    findAll()
 * @method WishlistPattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishlistPatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishlistPattern::class);
    }

    // /**
    //  * @return WishlistPattern[] Returns an array of WishlistPattern objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WishlistPattern
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
