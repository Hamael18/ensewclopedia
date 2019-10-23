<?php

namespace App\Controller;

use App\Entity\Version;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueVersionController extends AbstractController
{
    /**
     * @Route("/marque/pattern/show/{id}", name="marque_version_show")
     *
     * @param Version $version
     *
     * @return Response
     */
    public function showVersion(Version $version)
    {
        return $this->render('marque/version/show.html.twig', [
            'version' => $version
        ]);
    }
}
