<?php

namespace App\Controller;

use App\Entity\Style;
use App\Form\StyleType;
use App\Service\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStyleController extends AbstractController
{
    /**
     * @Route("/admin/version/style/{page<\d+>?1}", name="admin_style")
     *
     * @param $page
     *
     * @return Response
     */
    public function index(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Style::class)
            ->setRoute('admin_style')
            ->setPage($page);

        return $this->render('admin/style/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/admin/version/style/new", name="admin_style_new")
     *
     * @return RedirectResponse|Response
     */
    public function newStyle(Request $request)
    {
        $style = new Style();
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($style);
            $this->manager->flush();
            $this->addFlash('success', 'Style ajouté avec succès !');

            return $this->redirectToRoute('admin_style');
        }

        return $this->render('admin/style/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/version/style/edit/{id}", name="admin_style_edit")
     *
     * @return RedirectResponse|Response
     */
    public function editStyle(Request $request, Style $style)
    {
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Style modifié avec succès !');

            return $this->redirectToRoute('admin_style');
        }

        return $this->render('admin/style/edit.html.twig', [
            'form' => $form->createView(),
            'style' => $style,
        ]);
    }

    /**
     * @Route("/admin/version/style/delete/{id}", name="admin_style_delete")
     *
     * @return RedirectResponse
     */
    public function deleteStyle(Style $style)
    {
        $this->manager->remove($style);
        $this->manager->flush();
        $this->addFlash('success', 'Style supprimé avec succès !');

        return $this->redirectToRoute('admin_style');
    }
}
