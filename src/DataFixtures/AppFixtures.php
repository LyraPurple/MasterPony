<?php
namespace App\DataFixtures;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $product = new Product();
            $product->setName('iPhone '.$i);
            $product->setDescription('Un iPhone de '.$i);
            $product->setPrice(rand(10, 10000) * 100);
            $manager->persist($product);
        }
        $manager->flush();
    }
}