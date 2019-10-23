<?php

namespace App\Controller;

use App\Entity\Collar;
use App\Form\CollarType;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCollarController extends BaseAdminController
{
    /**
     * @Route("/admin/version/collar/{page<\d+>?1}", name="admin_collar")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     * @throws \Exception
     */
    public function listCollars(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Collar::class)
            ->setRoute('admin_collar')
            ->setPage($page);

        return $this->render('admin/collar/index.html.twig', [
            'pagination' => $pagination,
            'data' => $pagination->getData(),
        ]);
    }

    /**
     * @Route("/admin/version/collar/new", name="admin_collar_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newCollar(Request $request)
    {
        $collar = new Collar();
        $form = $this->createForm(CollarType::class, $collar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($collar);
            $this->manager->flush();
            $this->addFlash('success', 'Col ajouté avec succès !');

            return $this->redirectToRoute('admin_collar');
        }

        return $this->render('admin/collar/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/version/collar/edit/{id}", name="admin_collar_edit")
     *
     * @param Request $request
     * @param Collar  $collar
     *
     * @return RedirectResponse|Response
     */
    public function editStyle(Request $request, Collar $collar)
    {
        $form = $this->createForm(CollarType::class, $collar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Col modifié avec succès !');

            return $this->redirectToRoute('admin_collar');
        }

        return $this->render('admin/collar/edit.html.twig', [
            'form' => $form->createView(),
            'collar' => $collar,
        ]);
    }

    /**
     * @Route("/admin/version/collar/delete/{id}", name="admin_collar_delete")
     *
     * @param Collar $collar
     *
     * @return RedirectResponse
     */
    public function deleteStyle(Collar $collar)
    {
        $this->manager->remove($collar);
        $this->manager->flush();
        $this->addFlash('success', 'Col supprimé avec succès !');

        return $this->redirectToRoute('admin_collar');
    }
}
