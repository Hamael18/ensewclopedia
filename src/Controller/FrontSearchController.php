<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\FiltresTypesType;
use App\Repository\PatternRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontSearchController extends AbstractController
{
    /**
     * @Route("/advanced_search", name="front_search")
     * @param TypeRepository $typeRepo
     * @return Response
     */
    public function index(TypeRepository $typeRepo)
    {
        return $this->render('front_office/search/index.html.twig', [
            'types' => $typeRepo->findAll(),
        ]);
    }

    /**
     * @Route("/advanced_search/{slug}", name="search_by_type")
     * @param TypeRepository $typeRepo
     * @param Type $type
     * @param Request $request
     * @param PatternRepository $patternRepository
     * @return Response
     */
    public function filtresByType(
        TypeRepository $typeRepo,
        Type $type,
        Request $request,
        PatternRepository $patternRepository)
    {
        $patrons = $patternRepository->findPatternsAllByType($type);

        $form = $this->createForm(FiltresTypesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patrons = $patternRepository->findPatternsSearchByType($type, $form->getViewData());
            return $this->render('front_office/search/index.html.twig', [
                'types' => $typeRepo->findAll(),
                'attributs' => $type,
                'form' => $form->createView(),
                'patrons' => $patrons,
            ]);
        }

        return $this->render('front_office/search/index.html.twig', [
            'types' => $typeRepo->findAll(),
            'attributs' => $type,
            'form' => $form->createView(),
            'patrons' => $patrons
        ]);
    }
}
