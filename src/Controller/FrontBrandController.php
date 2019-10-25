<?php

namespace App\Controller;

use App\Entity\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontBrandController extends AbstractController
{
    /**
     * @Route("/front/brand/{slug}", name="front_brand")
     * @param Brand $brand
     *
     * @return Response
     */
    public function showBrand(Brand $brand)
    {
        return $this->render('front_office/brand.html.twig', [
            'brand' => $brand,
        ]);
    }
}
