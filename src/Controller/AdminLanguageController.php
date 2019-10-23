<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\NewLanguageType;
use App\Service\Pagination;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLanguageController extends BaseAdminController
{
    /**
     * @Route("/admin/pattern/language/{page<\d+>?1}", name="admin_language")
     *
     * @param Pagination $pagination
     * @param            $page
     *
     * @return Response
     * @throws Exception
     */
    public function listLanguages(Pagination $pagination, $page)
    {
        $pagination->setEntityClass(Language::class)
            ->setRoute('admin_language')
            ->setPage($page);

        return $this->render('admin/language/index.html.twig', [
            'pagination' => $pagination,
            'data' => $pagination->getData(),
        ]);
    }

    /**
     * @Route("/admin/pattern/language/new", name="admin_language_new")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newLanguage(Request $request)
    {
        $language = new Language();
        $form = $this->createForm(NewLanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($language);
            $this->manager->flush();
            $this->addFlash('success', 'Nouvelle langue ajouté avec succès !');

            return $this->redirectToRoute('admin_language');
        }

        return $this->render('admin/language/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/pattern/language/edit/{id}", name="admin_language_edit")
     *
     * @param Request  $request
     * @param Language $language
     *
     * @return RedirectResponse|Response
     */
    public function editLanguage(Request $request, Language $language)
    {
        $form = $this->createForm(NewLanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Langue modifiée avec succès !');

            return $this->redirectToRoute('admin_language');
        }

        return $this->render('admin/language/edit.html.twig', [
            'form' => $form->createView(),
            'language' => $language,
        ]);
    }

    /**
     * @Route("/admin/pattern/language/delete/{id}", name="admin_language_delete")
     *
     * @param Language $language
     *
     * @return RedirectResponse
     */
    public function deleteLanguage(Language $language)
    {
        $this->manager->remove($language);
        $this->manager->flush();
        $this->addFlash('success', 'Langue supprimée avec succès !');

        return $this->redirectToRoute('admin_language');
    }
}
