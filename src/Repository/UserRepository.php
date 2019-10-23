<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getDataFilterFromAdminBo($filterData)
    {
        $query = $this->createQueryBuilder('u');
        if ($filterData['email']) {
            $query->andWhere('u.email LIKE :email')
                ->setParameter('email', '%'.$filterData['email'].'%');
        }
        if ($filterData['roles']) {
            $query->join('u.roles', 'r')
                ->andWhere('r.libelle IN (:role)')
                ->setParameter('role', $filterData['roles']);
        }

        return $query->getQuery()
            ->execute();
    }
}
