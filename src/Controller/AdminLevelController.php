<?php

namespace App\Controller;

use App\Entity\Level;
use App\Form\NewLevelType;
use App\Service\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLevelController extends AbstractController
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/version/level/{page<\d+>?1}", name="admin_level")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     */
    public function listLevels(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Level::class)
            ->setRoute('admin_level')
            ->setPage($page);
        return $this->render('admin/level/list.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/version/level/new", name="admin_level_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newLevel(Request $request)
    {
        $level = new Level();
        $form = $this->createForm(NewLevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($level);
            $this->manager->flush();
            $this->addFlash('success', "Niveau de patron créé avec succès !");
            return $this->redirectToRoute('admin_level');
        }

        return $this->render('admin/level/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/version/level/edit/{id}", name="admin_level_edit")
     *
     * @param Request $request
     * @param Level   $level
     *
     * @return RedirectResponse|Response
     */
    public function editLevel(Request $request, Level $level)
    {
        $form = $this->createForm(NewLevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Niveau de patron modifié avec succès !");
            return $this->redirectToRoute('admin_level');
        }

        return $this->render('admin/level/edit.html.twig', [
            'form' => $form->createView(),
            'level' => $level
        ]);
    }

    /**
     * @Route("/admin/version/level/delete/{id}", name="admin_level_delete")
     *
     * @param Level $level
     *
     * @return RedirectResponse
     */
    public function deleteLevel(Level $level)
    {
        $this->manager->remove($level);
        $this->manager->flush();
        $this->addFlash('success', "Niveau de patron supprimé avec succès !");
        return $this->redirectToRoute('admin_level');
    }
}
