<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Tutoriel: https://blog.dev-web.io/2018/01/20/symfony-4-creation-de-fixtures-aleatoires-faker/
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        // on créé 100 cartes
        for ($i = 1; $i < 101; $i++) {
            $product = new Product();
            $product->setName($faker->unique()->numerify('iPhone ##'));
            $product->setDescription($faker->text);
            $product->setPrice($faker->numberBetween($min = 100, $max = 100000));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
