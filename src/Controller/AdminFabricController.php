<?php

namespace App\Controller;

use App\Entity\Fabric;
use App\Form\FabricType;
use App\Service\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFabricController extends AbstractController
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/version/fabric/{page<\d+>?1}", name="admin_fabric")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     *
     * @throws Exception
     */
    public function index(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Fabric::class)
            ->setRoute('admin_fabric')
            ->setPage($page);

        return $this->render('admin/fabric/index.html.twig', [
            'pagination' => $pagination,
            'data' => $pagination->getData(),
        ]);
    }

    /**
     * @Route("/admin/version/fabric/new", name="admin_fabric_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newFabric(Request $request)
    {
        $fabric = new Fabric();
        $form = $this->createForm(FabricType::class, $fabric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($fabric);
            $this->manager->flush();
            $this->addFlash('success', 'Tissu ajouté avec succès !');

            return $this->redirectToRoute('admin_fabric');
        }

        return $this->render('admin/fabric/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/version/fabric/edit/{id}", name="admin_fabric_edit")
     *
     * @param Request $request
     * @param Fabric  $fabric
     *
     * @return RedirectResponse|Response
     */
    public function editFabric(Request $request, Fabric $fabric)
    {
        $form = $this->createForm(FabricType::class, $fabric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Tissu modifié avec succès !');

            return $this->redirectToRoute('admin_fabric');
        }

        return $this->render('admin/fabric/edit.html.twig', [
            'form' => $form->createView(),
            'fabric' => $fabric,
        ]);
    }

    /**
     * @Route("/admin/version/fabric/delete/{id}", name="admin_fabric_delete")
     *
     * @param Fabric $fabric
     *
     * @return RedirectResponse
     */
    public function deleteFabric(Fabric $fabric)
    {
        $this->manager->remove($fabric);
        $this->manager->flush();
        $this->addFlash('success', 'Tissu supprimé avec succès !');

        return $this->redirectToRoute('admin_fabric');
    }
}
