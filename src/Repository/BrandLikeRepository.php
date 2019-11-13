<?php

namespace App\Repository;

use App\Entity\BrandLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BrandLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrandLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrandLike[]    findAll()
 * @method BrandLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrandLike::class);
    }

    // /**
    //  * @return BrandLike[] Returns an array of BrandLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BrandLike
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
