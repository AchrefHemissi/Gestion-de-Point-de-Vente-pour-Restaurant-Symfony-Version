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


$carteBancaire = new CarteBancaire();
$carteBancaire->setNumero(100100100);
$carteBancaire->setMontant(1000000);
$carteBancaire->setCode(123);

$manager->persist($carteBancaire);
    $manager->flush();


}
}