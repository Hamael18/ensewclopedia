<?php

namespace App\Repository;

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

    public function getQueryPatternsSearch($type)
    {
        $query = $this->createQueryBuilder('p')
            ->join('p.versions', 'versions')
            ->andWhere('versions.type = :type')
            ->setParameter('type', $type);

        return $query;
    }

    public function findPatternsAllByType($type)
    {
        return $this->getQueryPatternsSearch($type)
            ->getQuery()
            ->execute();
    }

    /**
     * @param Type $type
     * @param $data
     * @return mixed
     */
    public function findPatternsSearchByType($type, $data)
    {
        $query = $this->getQueryPatternsSearch($type);

        if ($type->getBoolLevel() == 1 and count($data['levels']) > 0) {
            $query
                ->join('versions.level', 'level')
                ->andWhere('level.name IN(:levels)')
                ->setParameter('levels', $data['levels']);
        }

        if ($type->getBoolLength() == 1 and count($data['lengths']) > 0) {
            $query
                ->join('versions.lengths', 'lengths')
                ->andWhere('lengths.name IN(:lengths)')
                ->setParameter('lengths', $data['lengths']);
        }

        if ($type->getBoolHandle() == 1 and count($data['handles']) > 0) {
            $query
                ->join('versions.handles', 'handles')
                ->andWhere('handles.name IN(:handles)')
                ->setParameter('handles', $data['handles']);
        }

        if ($type->getBoolSize() == 1 and count($data['sizes']) > 0) {
            $query
                ->join('versions.sizes', 'sizes')
                ->andWhere('sizes.libelle IN(:sizes')
                ->setParameter('sizes', $data['sizes']);
        }

        if ($type->getBoolCollar() == 1 and count($data['collars']) > 0) {
            $query
                ->join('versions.collars', 'collars')
                ->andWhere('collars.name IN(:collars')
                ->setParameter('collars', $data['collars']);
        }

        if ($type->getBoolFabric() == 1 and count($data['fabrics']) > 0) {
            $query
                ->join('versions.fabrics', 'fabrics')
                ->andWhere('fabrics.name IN(:fabrics)')
                ->setParameter('fabrics', $data['fabrics']);
        }

        if ($type->getBoolStyle() == 1 and count($data['styles']) > 0) {
            $query
                ->join('versions.styles', 'styles')
                ->andWhere('styles.name IN(:styles)')
                ->setParameter('styles', $data['styles']);
        }

        return $query
            ->getQuery()
            ->execute();
    }

    /**
     * Get
     *
     * @param User $user
     *
     * @return mixed
     */
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
