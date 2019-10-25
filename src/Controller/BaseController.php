<?php

namespace App\Controller;

use App\Repository\BrandLikeRepository;
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

    protected $brandLikeRepository;

    public function __construct(
        ObjectManager $manager,
        SessionInterface $session,
        PatternRepository $patternRepository,
        BrandRepository $brandRepository,
        BrandLikeRepository $brandLikeRepository
    )
    {
        $this->manager = $manager;
        $this->session = $session;
        $this->patternRepository = $patternRepository;
        $this->brandRepository = $brandRepository;
        $this->brandLikeRepository = $brandLikeRepository;
    }
}
