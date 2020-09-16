<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\AddTypeType;
use App\Form\EditTypeAttributsType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTypeController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/type", name="admin_type")
     *
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
     * @return RedirectResponse|Response
     */
    public function addType(Request $request)
    {
        $type = new Type();
        $form = $this->createForm(AddTypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($type);
            $this->manager->flush();
            $this->addFlash('success', 'Type créé avec succès !');

            return $this->redirectToRoute('admin_type');
        }

        return $this->render('admin/type/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/type/edit/{id}", name="admin_type_edit")
     *
     * @return RedirectResponse|Response
     */
    public function editType(Request $request, Type $type)
    {
        $form = $this->createForm(AddTypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($type);
            $this->manager->flush();
            $this->addFlash('success', 'Type modifié avec succès !');

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
     * @return RedirectResponse
     */
    public function deleteType(Type $type)
    {
        $this->manager->remove($type);
        $this->manager->flush();
        $this->addFlash('success', 'Type supprimé avec succès !');

        return $this->redirectToRoute('admin_type');
    }

    /**
     * @Route("/admin/type/editAttributs/{id}", name="admin_type_editAttributs")
     *
     * @return Response
     */
    public function addAttributsToType(Request $request, Type $type)
    {
        $form = $this->createForm(EditTypeAttributsType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Les attributs de ce type ont bien été mis à jour !');

            return $this->redirectToRoute('admin_type');
        }

        return $this->render('admin/type/editTypeAttributs.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }
}
