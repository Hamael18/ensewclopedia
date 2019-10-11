<?php


namespace App\Service;

use App\Entity\Brand;
use App\Entity\Pattern;
use App\Entity\User;
use PHPUnit\Runner\Exception;
use Symfony\Component\Security\Core\Security;

class FilterObjectsBrand
{
    private $entityClass;
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getFilterList()
    {
        if ($this->entityClass == Brand::class) {
            return $this->getFilterForBrand();
        } elseif ($this->entityClass == Pattern::class) {
            return $this->getFilterForPattern($this->security->getUser());
        }

        return new Exception();
    }

    public function getFilterForBrand()
    {
        return ['owner' => $this->security->getUser()];
    }

    /**
     * @param $user
     *
     * @return array
     */
    public function getFilterForPattern($user)
    {
        /** @var User $user $idBrandsOfUser */
        $idBrandsOfUser = [];
        foreach ($user->getBrands() as $brand) {
            /** @var Brand $brand */
            $idBrandsOfUser['brand'][] = $brand->getId();
        }
        return $idBrandsOfUser;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }
}
