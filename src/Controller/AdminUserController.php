<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\User;
use App\Form\AddBrandsToUserType;
use App\Form\EditUserRoleType;
use App\Form\SearchUserType;
use App\Service\Pagination;
use App\Service\setFilterCriteres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/user/{page<\d+>?1}", name="admin_user")
     *
     * @param $page
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function listUsers(Pagination $pagination, $page, Request $request, setFilterCriteres $setFilterCriteres)
    {
        $pagination->setEntityClass(User::class)
            ->setRoute('admin_user')
            ->setPage($page);

        $form = $this->createForm(SearchUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pagination = $setFilterCriteres->setFilterCustomFromUserFilter($form->getViewData(), $request);

            return $this->render('admin/user/index.html.twig', [
                'pagination' => $pagination,
                'data' => $pagination->getData(),
                'form' => $form->createView(),
            ]);
        }

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination,
            'data' => $pagination->getData(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     *
     * @return RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
        $this->addFlash('success', 'Utilisateur supprimé avec succès !');

        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/admin/user/edit_role/{id}", name="admin_user_editRole")
     *
     * @return RedirectResponse|Response
     */
    public function changeRoleUser(Request $request, User $user)
    {
        $form = $this->createForm(EditUserRoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', "Rôle de l'utilisateur modifié avec succès !");

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/editRole.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/{id}/addBrands", name="admin_user_addBrands")
     *
     * @return RedirectResponse|Response
     */
    public function addBrands(Request $request, User $user)
    {
        $form = $this->createForm(AddBrandsToUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()['brands'] as $brand) {
                /* @var Brand $brand */
                $user->addBrand($brand);
                $brand->setOwner($user);
                $this->manager->persist($brand);
            }
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', 'OK vite faut commiter');

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/addBrands.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/show/user/{id}", name="admin_user_show")
     *
     * @return Response
     */
    public function showUser(User $user)
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
