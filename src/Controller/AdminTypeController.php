<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\AddTypeType;
use App\Form\EditTypeAttributsType;
use App\Repository\TypeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin/type", name="admin_type")
     * @param TypeRepository $repository
     * @return Response
     */
    public function indexType(TypeRepository $repository)
    {
        return $this->render('admin/type/index.html.twig', [
            'types' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/type/add", name="admin_type_add")
     *
     * @param Request $request
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function addType(Request $request, ObjectManager $manager)
    {
        $type = new Type();
        $form = $this->createForm(AddTypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($type);
            $manager->flush();
            $this->addFlash('success', "Type créé avec succès !");

            return $this->redirectToRoute('admin_type');
        }

        return $this->render('admin/type/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/type/edit/{id}", name="admin_type_edit")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param Type $type
     *
     * @return RedirectResponse|Response
     */
    public function editType(Request $request, ObjectManager $manager, Type $type)
    {
        $form = $this->createForm(AddTypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($type);
            $manager->flush();
            $this->addFlash('success', "Type modifié avec succès !");

            return $this->redirectToRoute('admin_type');
        }

        return $this->render('admin/type/edit.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }

    /**
     * @Route("/admin/type/delete/{id}", name="admin_type_delete")
     *
     * @param ObjectManager $manager
     * @param Type $type
     *
     * @return RedirectResponse
     */
    public function deleteType(ObjectManager $manager, Type $type)
    {
        $manager->remove($type);
        $manager->flush();
        $this->addFlash('success', "Type supprimé avec succès !");

        return $this->redirectToRoute('admin_type');
    }

    /**
     * @Route("/admin/type/editAttributs/{id}", name="admin_type_editAttributs")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param Type $type
     *
     * @return Response
     */
    public function addAttributsToType(Request $request, ObjectManager $manager, Type $type)
    {
        $form = $this->createForm(EditTypeAttributsType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', "Les attributs de ce type ont bien été mis à jour !");

            return $this->redirectToRoute('admin_type');
        }

        return $this->render('admin/type/editTypeAttributs.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }
}
