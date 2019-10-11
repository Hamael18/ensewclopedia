<?php

namespace App\Controller;

use App\Entity\Handle;
use App\Form\HandleType;
use App\Service\Pagination;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHandleController extends BaseAdminController
{
    /**
     * @Route("/admin/version/handle/{page<\d+>?1}", name="admin_handle")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     * @throws Exception
     */
    public function listHandles(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Handle::class)
            ->setRoute('admin_handle')
            ->setPage($page);

        return $this->render('admin/handle/index.html.twig', [
            'pagination' => $pagination,
            'data' => $pagination->getData(),
        ]);
    }

    /**
     * @Route("/admin/version/handle/new", name="admin_handle_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newCollar(Request $request)
    {
        $handle = new Handle();
        $form = $this->createForm(HandleType::class, $handle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($handle);
            $this->manager->flush();
            $this->addFlash('success', 'Manches ajoutées avec succès !');

            return $this->redirectToRoute('admin_handle');
        }

        return $this->render('admin/handle/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/version/handle/edit/{id}", name="admin_handle_edit")
     *
     * @param Request $request
     * @param Handle  $handle
     *
     * @return RedirectResponse|Response
     */
    public function editStyle(Request $request, Handle $handle)
    {
        $form = $this->createForm(HandleType::class, $handle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Manches modifiées avec succès !');

            return $this->redirectToRoute('admin_handle');
        }

        return $this->render('admin/handle/edit.html.twig', [
            'form' => $form->createView(),
            'handle' => $handle,
        ]);
    }

    /**
     * @Route("/admin/version/handle/delete/{id}", name="admin_handle_delete")
     *
     * @param Handle $handle
     *
     * @return RedirectResponse
     */
    public function deleteStyle(Handle $handle)
    {
        $this->manager->remove($handle);
        $this->manager->flush();
        $this->addFlash('success', 'Manches supprimées avec succès !');

        return $this->redirectToRoute('admin_handle');
    }
}
