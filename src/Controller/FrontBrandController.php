<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\BrandLike;
use App\Entity\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontBrandController extends BaseController
{
    /**
     * @Route("/brand/{slug}", name="front_brand")
     * @param Brand $brand
     *
     * @return Response
     */
    public function showBrand(Brand $brand)
    {
        return $this->render('front_office/brand.html.twig', [
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/brand/{slug}/like", name="brand_like")
     * @param Brand $brand
     *
     * @return Response
     * @throws Exception
     */
    public function likeBrand(Brand $brand) : Response
    {
        $user = $this->getUser();

        if (!$user)
        {
            return $this->json(['code' => 403, 'message' => 'unauthorized'], 403);
        }

        if ($brand->isLikedByUser($user))
        {
            $like = $this->brandLikeRepository->findOneBy([
                'brand' => $brand,
                'user' => $user
            ]);

            $this->manager->remove($like);
            $this->manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Le like a été supprimé',
                'likes' => $this->brandLikeRepository->count(['brand' => $brand])
            ], 200);
        }

        $like = new BrandLike();
        $like->setBrand($brand)
            ->setUser($user)
            ->setCreatedAt(new \DateTime('now'));

        $this->manager->persist($like);
        $this->manager->flush();

        return $this->json([
            'code' => 200,
            'message'=> 'Le like a été ajouté',
            'likes' => $this->brandLikeRepository->count(['brand' => $brand])
            ], 200);
    }
}