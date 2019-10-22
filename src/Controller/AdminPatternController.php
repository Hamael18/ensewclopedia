<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Entity\Version;
use App\Form\PatternType;
use App\Form\VersionType;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPatternController extends BaseAdminController
{
    /**
     * @Route("/admin/pattern/{page<\d+>?1}", name="admin_pattern")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     */
    public function listPatterns(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Pattern::class)
            ->setRoute('admin_pattern')
            ->setPage($page);

        return $this->render('admin/pattern/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/admin/pattern/new", name="admin_pattern_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newPattern(Request $request)
    {
        $pattern = new Pattern();
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($pattern->getVersions() as $version) {
                $version->setPattern($pattern);
                $pattern->addVersion($version);
                $this->manager->persist($version);
            }
            $this->manager->persist($pattern);
            $this->manager->flush();
            $this->addFlash('success', 'Patron créé avec succès !');

            return $this->redirectToRoute('admin_pattern_addVersion', ['id' => $pattern->getId()]);
        }

        return $this->render('admin/pattern/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/pattern/edit/{id}", name="admin_pattern_edit")
     *
     * @param Request $request
     * @param Pattern $pattern
     *
     * @return RedirectResponse|Response
     */
    public function editPattern(Request $request, Pattern $pattern)
    {
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Patron modifié avec succès !');

            return $this->redirectToRoute('admin_pattern');
        }

        return $this->render('admin/pattern/edit.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern,
        ]);
    }

    /**
     * @Route("/admin/pattern/delete/{id}", name="admin_pattern_delete")
     *
     * @param Pattern $pattern
     *
     * @return RedirectResponse
     */
    public function deletePattern(Pattern $pattern)
    {
        $this->manager->remove($pattern);
        $this->manager->flush();
        $this->addFlash('success', 'Patron supprimé avec succès !');

        return $this->redirectToRoute('admin_pattern');
    }

    /**
     * @Route("/admin/pattern/add_version/{id}", name="admin_pattern_addVersion")
     *
     * @param Request $request
     * @param Pattern $pattern
     *
     * @return RedirectResponse|Response
     */
    public function addVersionToPattern(Request $request, Pattern $pattern)
    {
        $version = new Version();
        $form = $this->createForm(VersionType::class, $version);
        $form->remove('pattern');
        $version->setPattern($pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($version);
            $this->manager->flush();
            $this->addFlash('success', 'Version ajoutée avec succès !');

            return $this->redirectToRoute('admin_version');
        }

        return $this->render('bo_partials/_addVersion.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern,
        ]);
    }

    /**
     * @Route("/admin/pattern/show/{slug}", name="admin_pattern_show")
     *
     * @param Pattern $pattern
     *
     * @return Response
     */
    public function showPattern(Pattern $pattern)
    {
        return $this->render('admin/pattern/show.html.twig', [
            'pattern' => $pattern,
        ]);
    }
}
