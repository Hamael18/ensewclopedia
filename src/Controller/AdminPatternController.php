<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Entity\Version;
use App\Form\PatternType;
use App\Form\TypeVersionType;
use App\Form\VersionType;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPatternController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/pattern/{page<\d+>?1}", name="admin_pattern")
     *
     * @param $page
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
     * @Route("/admin/pattern/add_type_version/{id}", name="admin_pattern_addVersion")
     *
     * @return RedirectResponse|Response
     */
    public function addType(Request $request, Pattern $pattern)
    {
        $version = new Version();
        $form = $this->createForm(TypeVersionType::class, $version);
        $form->remove('pattern');
        $version->setPattern($pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($version);
            $this->manager->flush();
            $this->addFlash('success', 'Version créée avec succès !');

            return $this->redirectToRoute('admin_pattern_addVersion_attributs', [
                'id' => $version->getId(),
            ]);
        }

        return $this->render('bo_partials/_addTypeVersion.html.twig', [
            'form' => $form->createView(),
            'pattern' => $pattern,
        ]);
    }

    /**
     * @Route("/admin/pattern/add_attributs_version/{id}", name="admin_pattern_addVersion_attributs")
     *
     * @return RedirectResponse|Response
     */
    public function addVersionToPattern(Request $request, Version $version)
    {
        $form = $this->createForm(VersionType::class, $version);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($version);
            $this->manager->flush();
            $this->addFlash('success', 'Version complétée avec succès !');

            return $this->redirectToRoute('admin_pattern');
        }

        return $this->render('bo_partials/_addVersion.html.twig', [
            'form' => $form->createView(),
            'version' => $version,
        ]);
    }

    /**
     * @Route("/admin/pattern/show/{slug}", name="admin_pattern_show")
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
