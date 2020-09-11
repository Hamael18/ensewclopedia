<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Entity\PatternPatrontheque;
use App\Entity\User;
use App\Entity\WishlistPattern;
use App\Repository\PatternPatronthequeRepository;
use App\Repository\WishlistPatternRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPatternController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var PatternPatronthequeRepository
     */
    private $patternPatronthequeRepository;

    /**
     * @var WishlistPatternRepository
     */
    private $wishlistPatternRepository;

    public function __construct(
        ObjectManager $manager,
        PatternPatronthequeRepository $patternPatronthequeRepository,
        WishlistPatternRepository $wishlistPatternRepository)
    {
        $this->manager = $manager;
        $this->patternPatronthequeRepository = $patternPatronthequeRepository;
        $this->wishlistPatternRepository = $wishlistPatternRepository;
    }

    /**
     * @Route("/front/pattern/{slug}", name="front_pattern")
     * @param Pattern $pattern
     *
     * @return Response
     */
    public function showPattern(Pattern $pattern)
    {
        return $this->render('front_office/pattern.html.twig', [
            'pattern' => $pattern,
        ]);
    }

    /**
     * @Route("/pattern/{slug}/patrontheque", name="pattern_patrontheque")
     * @param Pattern $pattern
     *
     * @return Response
     * @throws Exception
     */
    public function isInPatrontheque(Pattern $pattern) : Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user)
        {
            return $this->json(['code' => 403, 'message' => 'unauthorized'], 403);
        }
        if ($pattern->inPatronthequeByUser($user))
        {
            $patrontheque = $this->patternPatronthequeRepository->findOneBy([
                'patrontheque' => $pattern,
                'patternPatrontheques' => $user
            ]);

            $this->manager->remove($patrontheque);
            $this->manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Le patron a été supprimé de la patrontheque',
                'patrontheque' => $this->patternPatronthequeRepository->count(['patrontheque' => $pattern])
            ], 200);
        }

        $patrontheque = new PatternPatrontheque();
        $patrontheque->setPatrontheque($pattern)
            ->setPatternPatrontheques($user)
            ->setCreatedAt(new \DateTime('now'));

        $this->manager->persist($patrontheque);
        $this->manager->flush();

        return $this->json([
            'code' => 200,
            'message'=> 'Le patron a été ajouté à la patrontheque',
            'patrontheque' => $this->patternPatronthequeRepository->count(['patrontheque' => $pattern])
        ], 200);

    }

    /**
     * @Route("/patrontheque", name="user_patrontheque")
     */
    public function patronthequeByUser()
    {

        $user = $this->getUser();
        $patrontheque = $this->patternPatronthequeRepository->findBy(['patternPatrontheques' => $user]);
        $patterns = [];

        foreach ($patrontheque as $pattern)
        {
            $patterns[] = $pattern->getPatrontheque();
        }
        return $this->render('front_office/patrontheque.html.twig', [
            'patterns' => $patterns,
        ]);

    }


    /**
     * @Route("/pattern/{slug}/wishlist", name="pattern_wishlist")
     * @param Pattern $pattern
     *
     * @return Response
     * @throws Exception
     */
    public function isInWishList(Pattern $pattern) : Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user)
        {
            return $this->json(['code' => 403, 'message' => 'unauthorized'], 403);
        }
        if ($pattern->inwishListByUser($user))
        {
            $pattern = $this->wishlistPatternRepository->findOneBy([
                'patternWish'=> $pattern,
                'userWish' => $user
            ]);

            $this->manager->remove($pattern);
            $this->manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Le patron a été supprimé de la wishlist',
                'wishlist' => $this->wishlistPatternRepository->count(['pattern' => $pattern])
            ], 200);
        }

        $wishlist = new WishlistPattern();
        $wishlist->setPattern($pattern)
            ->setUser($user)
            ->setCreatedAt(new \DateTime('now'));

        $this->manager->persist($wishlist);
        $this->manager->flush();

        return $this->json([
            'code' => 200,
            'message'=> 'Le patron a été ajouté à la wishlist',
            'wishlist' => $this->wishlistPatternRepository->count(['pattern' => $pattern])
        ], 200);

    }
}
