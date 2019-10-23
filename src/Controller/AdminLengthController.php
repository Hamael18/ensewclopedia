<?php

namespace App\Controller;

use App\Entity\Length;
use App\Form\LengthType;
use App\Repository\LengthRepository;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLengthController extends BaseAdminController
{
    /**
     * @Route("/admin/version/length/{page<\d+>?1}", name="admin_length")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     */
    public function listLengths(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Length::class)
            ->setRoute('admin_length')
            ->setPage($page);
        return $this->render('admin/length/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/version/length/new", name="admin_length_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newCollar(Request $request)
    {
        $length = new Length();
        $form = $this->createForm(LengthType::class, $length);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($length);
            $this->manager->flush();
            $this->addFlash('success', "Longueur ajoutée avec succès !");
            return $this->redirectToRoute('admin_length');
        }

        return $this->render('admin/length/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/version/length/edit/{id}", name="admin_length_edit")
     *
     * @param Request $request
     * @param Length  $length
     *
     * @return RedirectResponse|Response
     */
    public function editStyle(Request $request, Length $length)
    {
        $form = $this->createForm(LengthType::class, $length);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Longueur modifiée avec succès !");
            return $this->redirectToRoute('admin_length');
        }

        return $this->render('admin/length/edit.html.twig', [
            'form' => $form->createView(),
            'length' => $length
        ]);
    }

    /**
     * @Route("/admin/version/length/delete/{id}", name="admin_length_delete")
     *
     * @param Length $length
     *
     * @return RedirectResponse
     */
    public function deleteStyle(Length $length)
    {
        $this->manager->remove($length);
        $this->manager->flush();
        $this->addFlash('success', "Longueur supprimée avec succès !");
        return $this->redirectToRoute('admin_length');
    }
}
