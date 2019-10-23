<?php

namespace App\Controller;

use App\Entity\Size;
use App\Form\SizeType;
use App\Repository\SizeRepository;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSizeController extends BaseAdminController
{
    /**
     * @Route("/admin/version/size/{page<\d+>?1}", name="admin_size")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     */
    public function listSizes(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Size::class)
            ->setRoute('admin_size')
            ->setPage($page);
        return $this->render('admin/size/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/version/size/new", name="admin_size_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newSize(Request $request)
    {
        $size = new Size();
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($size);
            $this->manager->flush();
            $this->addFlash('success', "Taille créée avec succès !");
            return $this->redirectToRoute('admin_size');
        }

        return $this->render('admin/size/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/version/size/edit/{id}", name="admin_size_edit")
     *
     * @param Request $request
     * @param Size    $size
     *
     * @return RedirectResponse|Response
     */
    public function editSize(Request $request, Size $size)
    {
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Taille modifiée avec succès !");
            return $this->redirectToRoute('admin_size');
        }

        return $this->render('admin/size/edit.html.twig', [
            'form' => $form->createView(),
            'size' => $size
        ]);
    }

    /**
     * @Route("/admin/version/size/delete/{id}", name="admin_size_delete")
     *
     * @param Size $size
     *
     * @return RedirectResponse
     */
    public function deleteSize(Size $size)
    {
        $this->manager->remove($size);
        $this->manager->flush();
        $this->addFlash('success', "Taille supprimée avec succès !");
        return $this->redirectToRoute('admin_size');
    }
}
