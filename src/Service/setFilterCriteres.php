<?php

namespace App\Service;

use App\Entity\Pattern;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class setFilterCriteres
{
    private $pagination;
    private $userRepo;

    public function __construct(Pagination $pagination, UserRepository $userRepo)
    {
        $this->pagination = $pagination;
        $this->userRepo = $userRepo;
    }

    /**
     * A DRY, utilisable que pour un filtre de 'brand' pour le moment
     * Méthode permettant de récupérer des ID en vue de générer un tableau de critères pour
     * le service de pagination. Ne marche pas pour une requête custom.
     *
     * @param $dataForm
     * @param Request $request
     *
     * @return Pagination
     */
    public function setFilterBrand($dataForm, Request $request)
    {
        $criteres = [];
        foreach ($dataForm['brand'] as $brand) {
            $criteres['brand'][] = $brand->getId();
        }

        return $this->setPaginationService($criteres, $request);
    }

    /**
     * Méthode permettant de requeter avec les données envoyées par le filtre de la liste des utilisateurs
     * coté BO_ADMIN. Retourne le service de pagination avec un data custom venant du repo User.
     * @param $dataForm
     * @param Request $request
     * @return Pagination
     */
    public function setFilterCustomFromUserFilter($dataForm, Request $request)
    {
        $dataRepo = $this->userRepo->getDataFilterFromAdminBo($dataForm);

        $pagination = $this->pagination->setEntityClass(User::class)
                                        ->setRoute($request->attributes->get('_route'))
                                        ->setPage($request->attributes->get('page'))
                                        ->setFromFilter(true)
                                        ->setDataFromRepo($dataRepo);

        return $pagination;
    }

    /**
     * DRY validé.
     * Méthode permettant d'injecter un tableau de criteres récupéré via un filtre (des filtres ?)
     * dans le service de pagination. Le retour doit être réinjecté dans le template via un Controller
     * avec comme paramètre 'pagination'.
     *
     * @param $criteres
     * @param $request
     *
     * @return Pagination
     */
    public function setPaginationService($criteres, $request)
    {
        $filter = $this->pagination->setEntityClass(Pattern::class)
                                    ->setRoute($request->attributes->get('_route'))
                                    ->setPage($request->attributes->get('page'))
                                    ->setCriteres($criteres);

        return $filter;
    }
}
