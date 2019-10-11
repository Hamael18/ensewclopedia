<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\PatternRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BaseController extends AbstractController
{
    protected $manager;

    protected $patternRepository;

    protected $brandRepository;

    public function __construct(
        ObjectManager $manager,
        SessionInterface $session,
        PatternRepository $patternRepository,
        BrandRepository $brandRepository
    )
    {
        $this->manager = $manager;
        $this->session = $session;
        $this->patternRepository = $patternRepository;
        $this->brandRepository = $brandRepository;
    }
}
