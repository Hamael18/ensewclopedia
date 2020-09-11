<?php

namespace App\Controller;

use App\Entity\Version;
use App\Form\VersionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVersionController extends AbstractController
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
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

            return $this->redirectToRoute('admin_dashboard');
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

        return $this->redirectToRoute('admin_dashboard');
    }
}
