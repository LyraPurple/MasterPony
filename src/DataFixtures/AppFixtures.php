<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var SlugifyInterface
     */
    private $slugify;

    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Création des users
        $users = []; // Le tableau nous aide à retrouver les utilisateurs
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $manager->persist($user);
            $users[$i] = $user;
        }

        // Création des produits
        for ($i = 1; $i <= 100; $i++) {
            $product = new Product();
            $product->setName($faker->randomElement([
                'iPhone X', 'iPhone XS', 'iPhone XR', 'Galaxy S9', 'Galaxy S10'
            ]));
            $product->setDescription($faker->text(300));
            $product->setPrice($faker->randomNumber(5) * 100);
            // Je génère un slug
            // $this->slugify->slugify('iPhone X'); // iphone-x
            $slug = $this->slugify->slugify($product->getName());
            $product->setSlug($slug);
            // Très important, c'est grâce à cette ligne que le produit est lié au vendeur.
            $product->setUser($users[rand(1, 10)]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
