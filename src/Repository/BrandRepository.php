<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    /**
     * @return Brand[]
     */
    public function getBrandsWithoutOwner()
    {
        return $this->findBy(['owner' => null]);
    }

    /**
     * @param User $user
     *
     * @return QueryBuilder
     */
    public function getBrandsOfBrand(User $user)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.owner = :user')
            ->setParameter('user', $user)
            ->orderBy('b.name');
    }

    /*
     *
     */
    public function countBrand() {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) as count')
            ->getQuery()
            ->getResult();
    }
}
