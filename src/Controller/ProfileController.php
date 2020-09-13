<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BrandLikeRepository;
use App\Repository\PatternPatronthequeRepository;
use App\Repository\PatternRepository;
use App\Service\FavoritesRetriever;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @var PatternRepository
     */
    private $patternRepository;
    /**
     * @var BrandLikeRepository
     */
    private $brandLikeRepository;
    /**
     * @var PatternPatronthequeRepository
     */
    private $patternPatronthequeRepository;

    public function __construct(PatternRepository $patternRepository, BrandLikeRepository $brandLikeRepository, PatternPatronthequeRepository $patternPatronthequeRepository)
    {
        $this->patternRepository = $patternRepository;
        $this->brandLikeRepository = $brandLikeRepository;
        $this->patternPatronthequeRepository = $patternPatronthequeRepository;
    }

    /**
     * @Route("/profil", name="profile")
     */
    public function index()
    {
        /** @var User $user */
        $user = $this->getUser();

        $favoriteBrands = new FavoritesRetriever();
        $brands = $favoriteBrands->getFavoriteBrand($user, $this->brandLikeRepository);
        $news = $this->patternRepository->newestPatterns($user);

        return $this->render('front_office/profile.html.twig', [
            'user' => $user,
            'brands' => $brands,
            'news' => $news
        ]);
    }


    /**
     * @Route("/profil/patrontheque", name="user_patrontheque")
     */
    public function patronthequeByUser()
    {
        /** @var User $user */
        $user = $this->getUser();
        $patrontheque = new FavoritesRetriever();
        $patterns = $patrontheque->getPatrontheque($user, $this->patternPatronthequeRepository);

        return $this->render('front_office/patrontheque.html.twig', [
            'patterns' => $patterns,
        ]);

    }
}
