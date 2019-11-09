<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Gender;
use App\Entity\Handle;
use App\Entity\Language;
use App\Entity\Length;
use App\Entity\Level;
use App\Entity\Pattern;
use App\Entity\Role;
use App\Entity\Size;
use App\Entity\Style;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Version;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // ---> Roles
        $roleAdmin = new Role();
        $roleAdmin->setLibelle('ROLE_ADMIN');
        $roleMarque = new Role();
        $roleMarque->setLibelle('ROLE_MARQUE');
        $manager->persist($roleAdmin);
        $manager->persist($roleMarque);

        // ---> Users
        $userMarques = [];
        // Compte admin, mdp: password
        $userAdmin = new User();
        $userAdmin->setEmail('admin@demo.fr')
            ->setPassword($this->encoder->encodePassword($userAdmin, 'password'))
            ->setRoles($roleAdmin);
        $manager->persist($userAdmin);

        // Comptes Marque, mdp: password
        $userMarque1 = new User();
        $userMarque1->setEmail('marqueJulie@demo.fr')
            ->setPassword($this->encoder->encodePassword($userMarque1, 'password'))
            ->setRoles($roleMarque);
        $userMarques[] = $userMarque1;
        $userMarque2 = new User();
        $userMarque2->setEmail('marqueEtienne@demo.fr')
            ->setPassword($this->encoder->encodePassword($userMarque2, 'password'))
            ->setRoles($roleMarque);
        $userMarques[] = $userMarque2;
        $userMarque3 = new User();
        $userMarque3->setEmail('marqueDemo@demo.fr')
            ->setPassword($this->encoder->encodePassword($userMarque3, 'password'))
            ->setRoles($roleMarque);
        $userMarques[] = $userMarque3;

        foreach ($userMarques as $user) {
            $manager->persist($user);
        }

        // Types
        $types = [];
        $pantalon = new Type();
        $pantalon->setLibelle('Pantalon')
            ->setBoolCollar(0)
            ->setBoolFabric(1)
            ->setBoolHandle(0)
            ->setBoolLength(1)
            ->setBoolLevel(1)
            ->setBoolSize(0)
            ->setBoolStyle(0)
            ->setLogo('https://img.icons8.com/ios-filled/50/000000/trousers.png');
        $types[] = $pantalon;
        $gilet = new Type();
        $gilet->setLibelle('Gilet')
            ->setBoolCollar(1)
            ->setBoolFabric(1)
            ->setBoolHandle(1)
            ->setBoolLength(0)
            ->setBoolLevel(1)
            ->setBoolSize(0)
            ->setBoolStyle(1)
            ->setLogo('https://img.icons8.com/ios-glyphs/50/000000/vest.png');
        $types[] = $gilet;
        $allAttributType = new Type();
        $allAttributType->setLibelle('All attribut')
            ->setBoolCollar(1)
            ->setBoolFabric(1)
            ->setBoolHandle(1)
            ->setBoolLength(1)
            ->setBoolLevel(1)
            ->setBoolSize(1)
            ->setBoolStyle(1)
            ->setLogo('https://img.icons8.com/material-sharp/48/000000/creative-commons.png');
        $types[] = $allAttributType;
        $randomType = new Type();
        $randomType->setLibelle('Random Type')
            ->setBoolCollar($faker->boolean)
            ->setBoolFabric($faker->boolean)
            ->setBoolHandle($faker->boolean)
            ->setBoolLength($faker->boolean)
            ->setBoolLevel($faker->boolean)
            ->setBoolSize($faker->boolean)
            ->setBoolStyle($faker->boolean)
            ->setLogo('https://img.icons8.com/pastel-glyph/64/000000/empty-box.png');
        $types[] = $randomType;
        foreach ($types as $type) {
            $manager->persist($type);
        }

        // ---> Attributs marque
        // Languages
        $languages = [];
        for ($i = 1; $i <= 20; ++$i) {
            $language = new Language();
            $language->setName($faker->country);
            $languages[] = $language;
            $manager->persist($language);
        }

        // Genres
        $genres = [];
        $genre1 = new Gender();
        $genre1->setName('Homme');
        $genres[] = $genre1;
        $genre2 = new Gender();
        $genre2->setName('Femme');
        $genres[] = $genre2;
        $genre3 = new Gender();
        $genre3->setName('Enfant');
        $genres[] = $genre3;

        foreach ($genres as $genre) {
            $manager->persist($genre);
        }

        // ---> Attributs version
        // Cols
        $cols = [];
        $col1 = new Collar();
        $col1->setName('Col en V');
        $cols[] = $col1;
        $col2 = new Collar();
        $col2->setName('Col roulé');
        $cols[] = $col2;
        $col3 = new Collar();
        $col3->setName('Col claudine');
        $cols[] = $col3;
        $col4 = new Collar();
        $col4->setName('Col rond');
        $cols[] = $col4;

        foreach ($cols as $col) {
            $manager->persist($col);
        }

        // Difficultés
        $difficultes = [];
        $facile = new Level();
        $facile->setName('Facile');
        $difficultes[] = $facile;
        $inter = new Level();
        $inter->setName('Intermédiaire');
        $difficultes[] = $inter;
        $diff = new Level();
        $diff->setName('Difficile');
        $difficultes[] = $diff;

        foreach ($difficultes as $difficulte) {
            $manager->persist($difficulte);
        }

        // Longueurs
        $longProvider = ['S2', 'N4', 'L2', 'N6', 'S4', 'L6', 'S6', 'L4', 'N2'];
        $longueurs = [];

        foreach ($longProvider as $long) {
            $longueur = new Length();
            $longueur->setName($long);
            $longueurs[] = $longueur;
            $manager->persist($longueur);
        }

        // Tailles
        $tailleProvider = [32, 34, 36, 38, 40, 42, 44, 46, 48, 50, 52, 54, 56];
        $tailles = [];

        foreach ($tailleProvider as $tai) {
            $taille = new Size();
            $taille->setLibelle($tai);
            $tailles[] = $taille;
            $manager->persist($taille);
        }

        // Manches
        $manchesProvider = ['Manches courtes', 'Manches longues'];
        $manches = [];

        foreach ($manchesProvider as $man) {
            $manche = new Handle();
            $manche->setName($man);
            $manches[] = $manche;
            $manager->persist($manche);
        }

        // Tissus
        $tissusProvider = ['Soie', 'Toile', 'Lycra', 'Dentelle', 'Velours'];
        $tissus = [];

        foreach ($tissusProvider as $tis) {
            $tissu = new Fabric();
            $tissu->setName($tis)
                ->setExtensible($faker->boolean);
            $tissus[] = $tissu;
            $manager->persist($tissu);
        }

        // Styles
        $stylesProvider = ['Décontracté', 'Hiver', 'Automne', 'Plage', 'Montagne', 'Grosse tempête'];
        $styles = [];

        foreach ($stylesProvider as $sty) {
            $style = new Style();
            $style->setName($sty);
            $styles[] = $style;
            $manager->persist($style);
        }

        $manager->flush();

        // ---> Marques
        $marques = [];

        // Marques avec propriétaires
        foreach ($userMarques as $userMarque) {
            $m = $faker->randomElement([2, 3, 5]);
            for ($n = 1; $n <= $m; ++$n) {
                $image = $faker->image('/var/www/html/public/uploads/brand_images', 1000, 400, 'cats', false);
                $marque = new Brand();
                $marque->setName($faker->company)
                    ->setDescription($faker->text(300))
                    ->setUrl($faker->url)
                    ->setOwner($userMarque)
                    ->setImage($image);
                $marques[] = $marque;
                $manager->persist($marque);
            }
        }

        // 10 marques sans propriétaires
        for ($j = 1; $j <= 10; ++$j) {
            $image = $faker->image('/var/www/html/public/uploads/brand_images', 1000, 400, 'cats', false);
            $marque = new Brand();
            $marque->setName($faker->company)
                ->setDescription($faker->text(300))
                ->setUrl($faker->url)
                ->setImage($image);
            $manager->persist($marque);
        }

        $manager->flush();

        // ---> Patrons par marque avec proprio --> 1 à 3 versions pour chaque patron

        $versionsNameProvider = ['SYLVIE', 'SANDRINE', 'SANDRA', 'ETIENNE', 'THOMAS', 'JULIE', 'LAURA', 'MAMAN', 'COTOREP', 'YANN', 'ORANGINA'];

        foreach ($marques as $marque) {
            $nbPatrons = $faker->randomElement([2, 3, 5]);
            for ($pa = 1; $pa <= $nbPatrons; ++$pa) {
                $patron = new Pattern();
                $image_pattern = $faker->image('/var/www/html/public/uploads/pattern_images', 1000, 400, 'nightlife', false);
                $patron->setName($faker->company.' '.$faker->numberBetween(2000, 8000))
                    ->setDescription($faker->text(150))
                    ->setPrice($faker->randomFloat(2, 10, 50))
                    ->setLien($faker->url)
                    ->setCreatedAt($faker->dateTimeBetween('-6months', 'now'))
                    ->setBrand($marque)
                    ->setImage($image_pattern);

                // Ajout d'un nombre aléatoire de genres (max : nombre de genres dans $genres)
                $nbGenres = count($genres);
                for ($nbg = 1; $nbg <= $faker->numberBetween(1, $nbGenres); ++$nbg) {
                    $patron->addGenre($faker->randomElement($genres));
                }

                // Ajout d'un nombre aléatoire de langues (max: nombre de langues dans $languages)
                $nbLang = count($languages);
                for ($nbl = 1; $nbl <= $faker->numberBetween(1, $nbLang); ++$nbl) {
                    $patron->addLanguage($faker->randomElement($languages));
                }

                // Ajout de versions (1 à 3) par patron
                $p = $faker->randomElement([1, 2, 3]);
                for ($q = 1; $q <= $p; ++$q) {
                    $version = new Version();
                    $version->setName($faker->randomElement($versionsNameProvider))
                        ->setLevel($faker->randomElement($difficultes))
                        ->setPattern($patron)
                        ->setType($faker->randomElement($types))
                        ->setImage($faker->imageUrl(300, 200));
                    // Ajout des attributs

                    $nbCol = count($cols);
                    for ($nbc = 1; $nbc <= $faker->numberBetween(0, $nbCol); ++$nbc) {
                        $version->addCollar($faker->randomElement($cols));
                    }

                    $nbLen = count($longueurs);
                    for ($nblo = 1; $nblo <= $faker->numberBetween(0, $nbLen); ++$nblo) {
                        $version->addLength($faker->randomElement($longueurs));
                    }

                    $nbHan = count($manches);
                    for ($nbh = 1; $nbh <= $faker->numberBetween(0, $nbHan); ++$nbh) {
                        $version->addHandle($faker->randomElement($manches));
                    }

                    $nbTis = count($tissus);
                    for ($nbt = 1; $nbt <= $faker->numberBetween(0, $nbTis); ++$nbt) {
                        $version->addFabric($faker->randomElement($tissus));
                    }

                    $nbSty = count($styles);
                    for ($nbst = 1; $nbst <= $faker->numberBetween(0, $nbSty); ++$nbst) {
                        $version->addStyle($faker->randomElement($styles));
                    }

                    $nbSiz = count($tailles);
                    for ($nbsi = 1; $nbsi <= $faker->numberBetween(0, $nbSiz); ++$nbsi) {
                        $version->addSize($faker->randomElement($tailles));
                    }

                    $manager->persist($version);
                }
                $manager->persist($patron);
            }
        }

        $manager->flush();
    }
}
