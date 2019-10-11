<?php


namespace App\Tests\Unit;


use App\Entity\Brand;
use App\Entity\User;
use App\Service\FilterObjectsBrand;
use PHPUnit\Framework\TestCase;

class FilterBrandTest extends TestCase
{
    public function testGetIds()
    {
        $filter = new FilterObjectsBrand();
        $user = new User();
        $user->setEmail('testBrand@hotmail.fr');
        $brand = new Brand();
        $brand->setOwner($user)
            ->setName('marque1')
            ->setId('123456');
        $brand2 = new Brand();
        $brand2->setOwner($user)
            ->setName('marque2')
            ->setId('789456');
        $user->addBrand($brand);
        $user->addBrand($brand2);
        $result = $filter->getIdsBrand($user);

        $this->assertSame($result['brand'][0], 123456);
        $this->assertSame($result['brand'][1], 789456);
    }
}