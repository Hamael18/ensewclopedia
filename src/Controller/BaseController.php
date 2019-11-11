<?php

namespace App\Controller;

use App\Repository\BrandLikeRepository;
use App\Repository\BrandRepository;
use App\Repository\PatternPatronthequeRepository;
use App\Repository\PatternRepository;
use App\Repository\WishlistPatternRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BaseController extends AbstractController
{
    protected $manager;

    protected $patternRepository;

    protected $brandRepository;

    protected $brandLikeRepository;

    protected $patternPatronthequeRepository;

    protected $wishlistPatternRepository;

    public function __construct(
        ObjectManager $manager,
        SessionInterface $session,
        PatternRepository $patternRepository,
        BrandRepository $brandRepository,
        BrandLikeRepository $brandLikeRepository,
        PatternPatronthequeRepository $patternPatronthequeRepository,
        WishlistPatternRepository $wishlistPatternRepository
    )
    {
        $this->manager = $manager;
        $this->session = $session;
        $this->patternRepository = $patternRepository;
        $this->brandRepository = $brandRepository;
        $this->brandLikeRepository = $brandLikeRepository;
        $this->patternPatronthequeRepository = $patternPatronthequeRepository;
        $this->wishlistPatternRepository = $wishlistPatternRepository;
    }
}
