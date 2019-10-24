<?php

namespace App\Controller;

use App\Entity\Pattern;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPatternController extends AbstractController
{
    /**
     * @Route("/front/pattern/{slug}", name="front_pattern")
     * @param Pattern $pattern
     *
     * @return Response
     */
    public function showPattern(Pattern $pattern)
    {
        return $this->render('front_office/pattern.html.twig', [
            'pattern' => $pattern,
        ]);
    }
}
