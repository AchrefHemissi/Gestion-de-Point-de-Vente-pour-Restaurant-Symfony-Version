<?php
// src/DataFixtures/CarteBancaireFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CarteBancaire;
use Faker\Factory;

class CarteBancaireFixtures extends Fixture
{
public function load(ObjectManager $manager)
{
$faker = Factory::create();

for ($i = 0; $i < 20; $i++) {
$carteBancaire = new CarteBancaire();
$carteBancaire->setNumero($faker->randomNumber(8));
$carteBancaire->setMontant($faker->randomNumber(3));
$carteBancaire->setCode($faker->randomNumber(3));

$manager->persist($carteBancaire);
}

$manager->flush();
}
}