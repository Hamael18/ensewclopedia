<?php

namespace App\Controller;

use App\Service\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalSearchController extends AbstractController
{
    private $checkRole;

    public function __construct(UserRole $checkRole)
    {
        $this->checkRole = $checkRole;
    }

    /**
     * @Route("/search/global_results", name="app_global_search")
     * @param Request $request
     * @return Response
     */
    public function getGlobalSearch(Request $request)
    {
        $search = $request->request->get('search_content');
        if ($this->checkRole->getUserRole() == 'ADMIN') {
            $results = $this->getResultsFromAdmin($search);
        } else {
            $results = $this->getResultatsFromBrand($search);
        }
        return $this->render('bo_partials/_results_global_search.html.twig', [
            'results' => $results
        ]);
    }

    private function getResultsFromAdmin($search)
    {
        return true;
    }

    private function getResultatsFromBrand($search)
    {
        return true;
    }
}
