<?php

namespace App\Controller;

use App\Repository\PatternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     * @param PatternRepository $patternRepo
     *
     * @return Response
     */
    public function index(PatternRepository $patternRepo)
    {
        return $this->render('front_office/index.html.twig', [
            'lastPatterns' => $patternRepo->findBy([], ['createdAt' => 'DESC'], 10),
        ]);
    }
}
