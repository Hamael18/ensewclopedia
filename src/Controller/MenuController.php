<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/brandsList", name="brandsList")
     *
     * @param BrandRepository $brandRepository
     *
     * @return Response
     */
    public function brandsList(BrandRepository $brandRepository)
    {
        return $this->render('front_office/menu.html.twig', [
            'brands' => $brandRepository->findAll(),
        ]);
    }
}
