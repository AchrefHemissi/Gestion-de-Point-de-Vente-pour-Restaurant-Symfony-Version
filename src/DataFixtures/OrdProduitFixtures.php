<?php
// src/DataFixtures/OrdProduitFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\OrdProduit;
use App\Entity\Commande;
use App\Entity\Produit;
use Faker\Factory;

class OrdProduitFixtures extends Fixture
{

    public function getDependencies()
    {
        return [
            CommandeFixtures::class,
            ProduitFixtures::class,
        ];
    }
public function load(ObjectManager $manager)
{
$faker = Factory::create();

for ($i = 0; $i < 20; $i++) {
$ordProduit = new OrdProduit();
$ordProduit->setIdCommande($faker->randomElement($manager->getRepository(Commande::class)->findAll()));
$ordProduit->setIdProduit($faker->randomElement($manager->getRepository(Produit::class)->findAll()));
$ordProduit->setQuantity($faker->randomNumber(2));

$manager->persist($ordProduit);
    $manager->flush();
}


}
}