<?php

namespace App\Repository;

use App\Entity\Handle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Handle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Handle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Handle[]    findAll()
 * @method Handle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HandleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Handle::class);
    }

    // /**
    //  * @return Handle[] Returns an array of Handle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Handle
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
