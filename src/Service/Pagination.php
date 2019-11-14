<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Pagination
{
    private $entityClass;
    private $limit = 15;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;
    private $criteres = [];
    private $order = [];
    private $user;
    private $filter;
    private $fromFilter;
    private $dataFromRepo;

    /**
     * Pagination constructor.
     *
     * @param ObjectManager $manager
     * @param Environment   $twig
     * @param RequestStack  $request
     * @param $templatePath
     * @param Security $security
     */
    public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath, Security $security, FilterObjectsBrand $filter)
    {
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
        $this->templatePath = $templatePath;
        $this->user = $security->getUser();
        $this->filter = $filter;
        $this->fromFilter = false;
    }

    /**
     * @return mixed
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param $templatePath
     *
     * @return $this
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }

    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function display()
    {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route,
        ]);
    }

    /**
     * @return float|int
     *
     * @throws Exception
     */
    public function getPages()
    {
        if (empty($this->entityClass)) {
            throw new Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! 
            Utilisez la méthode setEntityClass() de votre objet Pagination");
        }

        if (in_array('ROLE_MARQUE', $this->user->getRoles())) {
            return $this->getPagesByBrand($this->filter);
        } elseif ($this->dataFromRepo) {
            return $this->countPages($this->dataFromRepo);
        } else {
            return $this->getPagesFindAll();
        }
    }

    private function getPagesFindAll()
    {
        $repo = $this->manager->getRepository($this->entityClass);
        $list = $repo->findAll();

        return $this->countPages($list);
    }

    private function getPagesByBrand(FilterObjectsBrand $filter)
    {
        $filter->setEntityClass($this->entityClass);
        $filter_list = $filter->getFilterList();
        $repo = $this->manager->getRepository($this->entityClass);
        $list = $repo->findBy($filter_list);

        return $this->countPages($list);
    }

    private function countPages($listObjects)
    {
        $total = count($listObjects);
        $pages = $total > 0 ? $pages = ceil($total / $this->limit) : 1;

        return $pages;
    }

    /**
     * @return object[]
     *
     * @throws Exception
     */
    public function getData()
    {
        if (empty($this->entityClass)) {
            throw new Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! 
            Utilisez la méthode setEntityClass() de votre objet Pagination");
        }
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);

        if (false == $this->fromFilter) {
            $data = $repo->findBy($this->criteres, $this->order, $this->limit, $offset);
        } else {
            return $this->dataFromRepo;
        }

        return $data;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function getPage()
    {
        return $this->currentPage;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;

        return $this;
    }

    public function getCriteres()
    {
        return $this->criteres;
    }

    public function setCriteres(array $criteres)
    {
        $this->criteres = $criteres;

        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(array $order)
    {
        $this->order = $order;

        return $this;
    }

    public function getFromFilter()
    {
        return $this->fromFilter;
    }

    public function setFromFilter(bool $fromFilter)
    {
        $this->fromFilter = $fromFilter;

        return $this;
    }

    public function getDataFromRepo()
    {
        return $this->dataFromRepo;
    }

    public function setDataFromRepo($dataFromRepo)
    {
        $this->dataFromRepo = $dataFromRepo;

        return $this;
    }
}
