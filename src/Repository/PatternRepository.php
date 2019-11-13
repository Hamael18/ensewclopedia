<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Pattern;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pattern[]    findAll()
 * @method Pattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatternRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pattern::class);
    }

    /**
     * @return mixed
     */
    public function countPatterns()
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p) as count')
            ->getQuery()
            ->getResult();
    }

    public function newestPatterns(User $user)
    {
        return $this->createQueryBuilder('p')
            ->join('p.brand',"b")
            ->join('b.likes', 'bl')
            ->andWhere('bl.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
