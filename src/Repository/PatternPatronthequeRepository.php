<?php

namespace App\Repository;

use App\Entity\PatternPatrontheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PatternPatrontheque|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatternPatrontheque|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatternPatrontheque[]    findAll()
 * @method PatternPatrontheque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatternPatronthequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatternPatrontheque::class);
    }

    // /**
    //  * @return PatternPatrontheque[] Returns an array of PatternPatrontheque objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PatternPatrontheque
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
