<?php


namespace App\Service;

use App\Entity\User;
use App\Repository\BrandLikeRepository;
use App\Repository\PatternPatronthequeRepository;
use App\Repository\WishlistPatternRepository;
use Doctrine\Persistence\ObjectManager;

/**
 * Class FavoritesBrand
 *
 * @author Julie Trannois trannois_julie@yahoo.fr
 */
class FavoritesRetriever
{

    public function getFavoriteBrand(User $user, BrandLikeRepository $brandLikeRepository)
    {
        $favoriteBrands = $brandLikeRepository->findBy(['user' => $user]);

        if (!$favoriteBrands) {
            return null;
        }

        foreach ($favoriteBrands as $brand)
        {
            $brands[] = $brand->getBrand();
        }

        return $brands;
    }

    public function getPatrontheque(User $user, PatternPatronthequeRepository $patronthequeRepository)
    {
        $patrontheque = $patronthequeRepository->findBy(['patternPatrontheques' => $user]);

        if (!$patrontheque) {
            return null;
        }

        foreach ($patrontheque as $pattern)
        {
            $patterns[] = $pattern->getPatrontheque();
        }

        return $patterns;
    }

    public function getWishlist(User $user, WishlistPatternRepository $wishlistPatternRepository)
    {
        $wishlist = $wishlistPatternRepository->findBy(['user' => $user]);

        if (!$wishlist) {
            return null;
        }

        foreach ($wishlist as $pattern)
        {
            $patterns[] = $pattern->getPattern();
        }

        return $patterns;
    }
}