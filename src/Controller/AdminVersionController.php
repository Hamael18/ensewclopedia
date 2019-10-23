<?php

namespace App\Controller;

use App\Entity\Version;
use App\Form\VersionType;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVersionController extends BaseAdminController
{
    /**
     * @Route("/admin/version/{page<\d+>?1}", name="admin_version")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     */
    public function listVersions(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Version::class)
            ->setRoute('admin_brand')
            ->setPage($page);

        return $this->render('admin/version/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/admin/version/show/{id}", name="admin_version_show")
     *
     * @param Version $version
     *
     * @return Response
     */
    public function showVersion(Version $version)
    {
        return $this->render('admin/version/show.html.twig', [
            'version' => $version,
        ]);
    }

    /**
     * @Route("/admin/version/edit/{id}", name="admin_version_edit")
     *
     * @param Request $request
     * @param Version $version
     *
     * @return RedirectResponse|Response
     */
    public function editVersion(Request $request, Version $version)
    {
        $form = $this->createForm(VersionType::class, $version);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Version modifiée avec succès !');

            return $this->redirectToRoute('admin_version');
        }

        return $this->render('admin/version/edit.html.twig', [
            'form' => $form->createView(),
            'version' => $version,
            'pattern' => $version->getPattern(),
        ]);
    }

    /**
     * @Route("/admin/version/delete/{id}", name="admin_version_delete")
     *
     * @param Version $version
     *
     * @return RedirectResponse
     */
    public function deleteVersion(Version $version)
    {
        $this->manager->remove($version);
        $this->manager->flush();
        $this->addFlash('success', 'Version supprimée avec succès !');

        return $this->redirectToRoute('admin_version');
    }
}
