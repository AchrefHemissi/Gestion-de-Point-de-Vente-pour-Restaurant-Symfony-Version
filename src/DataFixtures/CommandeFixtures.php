<?php

namespace App\DataFixtures;
// src/DataFixtures/CommandeFixtures.php

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Commande;
use Faker\Factory;
use App\Entity\Utilisateur;

class CommandeFixtures extends Fixture
{
    public function getDependencies()
    {
        return [
            UtilisateurFixtures::class,
            CarteBancaireFixtures::class,
        ];
    }
public function load(ObjectManager $manager)
{
$faker = Factory::create();

for ($i = 0; $i < 20; $i++) {
$commande = new Commande();
$commande->setIdClient($faker->randomElement($manager->getRepository(Utilisateur::class)->findAll()));
$commande->setDateCommande($faker->dateTime);
$commande->setLieu($faker->city);
$commande->setEtatCommande($faker->boolean);

$manager->persist($commande);
}

$manager->flush();
}
}