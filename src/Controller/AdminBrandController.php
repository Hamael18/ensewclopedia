<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandOwnerType;
use App\Form\BrandType;
use App\Service\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBrandController extends AbstractController
{
    protected $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/brand/{page<\d+>?1}", name="admin_brand")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     * @throws \Exception
     */
    public function listBrand(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Brand::class)
            ->setRoute('admin_brand')
            ->setPage($page);

        return $this->render('admin/brand/index.html.twig', [
            'pagination' => $pagination,
            'data' => $pagination->getData(),
        ]);
    }

    /**
     * @Route("/admin/brand/new", name="admin_brand_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function createBrand(Request $request)
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($brand);
            $this->manager->flush();
            $this->addFlash('success', 'Marque créé avec succès !');

            return $this->redirectToRoute('admin_brand');
        }

        return $this->render('admin/brand/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/brand/edit/{id}", name="admin_brand_edit")
     *
     * @param Request $request
     * @param Brand   $brand
     *
     * @return RedirectResponse|Response
     */
    public function editBrand(Request $request, Brand $brand)
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Marque modifiée avec succès !');

            return $this->redirectToRoute('admin_brand');
        }

        return $this->render('admin/brand/edit.html.twig', [
            'form' => $form->createView(),
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/admin/brand/delete/{id}", name="admin_brand_delete")
     *
     * @param Brand $brand
     *
     * @return RedirectResponse
     */
    public function deleteBrand(Brand $brand)
    {
        $this->manager->remove($brand);
        $this->manager->flush();
        $this->addFlash('success', 'Marque supprimée avec succès !');

        return $this->redirectToRoute('admin_brand');
    }

    /**
     * @Route("admin/brand/{id}/add_owner", name="admin_brand_addOwner")
     *
     * @param Request $request
     * @param Brand   $brand
     *
     * @return RedirectResponse|Response
     */
    public function addOwner(Request $request, Brand $brand)
    {
        $form = $this->createForm(BrandOwnerType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "L'utilisateur a été identifié comme propriétaire de la marque");

            return $this->redirectToRoute('admin_brand');
        }

        return $this->render('admin/brand/addOwner.html.twig', [
            'form' => $form->createView(),
            'brand' => $brand,
        ]);
    }
}
