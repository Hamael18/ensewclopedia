<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends BaseController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        $user = $this->getUser();
        $favoriteBrands = $this->brandLikeRepository->findBy(['user' => $user]);
        $news = $this->patternRepository->newestPatterns($user);
dump($news);
        foreach ($favoriteBrands as $brand)
        {
            $brands[] = $brand->getBrand();
        }

        return $this->render('front_office/profile.html.twig', [
            'user' => $user,
            'brands' => $brands,
            'news' => $news
        ]);
    }
}
