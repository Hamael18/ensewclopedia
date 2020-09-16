<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\PatternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseAdminController extends AbstractController
{
    /**
     * @var PatternRepository
     */
    protected $patternRepository;

    /**
     * @var BrandRepository
     */
    protected $brandRepository;

    public function __construct(
        PatternRepository $patternRepository,
        BrandRepository $brandRepository
    ) {
        $this->patternRepository = $patternRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminIndex()
    {
        return $this->render('admin/dashboard/dashboard.html.twig', [
            'patternCount' => $this->patternRepository->countPatterns(),
            'brandCount' => $this->brandRepository->countBrand(),
        ]);
    }

    /**
     * @Route("/marque", name="marque_dashboard")
     *
     * @return Response
     */
    public function marqueIndex()
    {
        return $this->render('marque/dashboard/dashboard.html.twig');
    }
}
