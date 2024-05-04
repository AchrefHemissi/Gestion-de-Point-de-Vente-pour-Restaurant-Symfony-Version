<?php
// src/DataFixtures/ProduitFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produit;
use Faker\Factory;

class ProduitFixtures extends Fixture
{
public function load(ObjectManager $manager)
{
$faker = Factory::create();

for ($i = 0; $i < 8; $i++) {
$produit = new Produit();
$produit->setName($faker->word);
$produit->setPrix($faker->randomNumber(2));
$produit->setVendu($faker->randomNumber(2));
$produit->set_is_Drink($faker->boolean);
$produit->setImgPath("https://picsum.photos/200/300");

$manager->persist($produit);
    $manager->flush();
}


}
}