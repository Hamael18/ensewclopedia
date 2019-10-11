<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BaseAdminController extends BaseController
{
    protected $manager;
    protected $session;

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminIndex()
    {
        return $this->render('admin/dashboard/dashboard.html.twig', [
            'patternCount' =>$this->patternRepository->countPatterns(),
            'brandCount' =>$this->brandRepository->countBrand()
        ]);
    }

    /**
     * @Route("/marque", name="marque_dashboard")
     * @return Response
     */
    public function marqueIndex()
    {
        return $this->render('marque/dashboard/dashboard.html.twig');
    }
}
