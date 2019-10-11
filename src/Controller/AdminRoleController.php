<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRoleController extends AbstractController
{
    /**
     * @Route("/admin/role", name="admin_role")
     * @param RoleRepository $repository
     * @return Response
     */
    public function index(RoleRepository $repository)
    {
        return $this->render('admin/role/index.html.twig', [
            'roles' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/admin/role/add_role", name="admin_role_add")
     * @param Request $request
     * @param ObjectManager $manager
     * @return RedirectResponse|Response
     */
    public function addRole(Request $request, ObjectManager $manager)
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($role);
            $manager->flush();
            $this->addFlash('success', "Rôle créé avec succès !");
            return $this->redirectToRoute('admin_role');
        }

        return $this->render('admin/role/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/role/edit/{id}", name="admin_role_edit")
     * @param Request $request
     * @param ObjectManager $manager
     * @param Role $role
     * @return RedirectResponse|Response
     */
    public function editRole(Request $request, ObjectManager $manager, Role $role)
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', "Rôle édité avec succès !");
            return $this->redirectToRoute('admin_role');
        }

        return $this->render('admin/role/edit.html.twig', [
            'form' => $form->createView(),
            'role' => $role
        ]);
    }

    /**
     * @Route("/admin/role/delete/{id}", name="admin_role_delete")
     * @param Role $role
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function deleteRole(Role $role, ObjectManager $manager)
    {
        $manager->remove($role);
        $manager->flush();
        $this->addFlash('success', "Rôle supprimé avec succès !");

        return $this->redirectToRoute('admin_role');
    }
}
