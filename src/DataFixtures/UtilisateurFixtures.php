<?php
// src/DataFixtures/UtilisateurFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use Faker\Factory;

class UtilisateurFixtures extends Fixture
{
    public static function getGroups(): array
    {
        return ['group1'];
    }
public function load(ObjectManager $manager)
{
$faker = Factory::create();

for ($i = 0; $i < 20; $i++) {
$utilisateur = new Utilisateur();
$utilisateur->setNom($faker->lastName);
$utilisateur->setPrenom($faker->firstName);
$utilisateur->setEmail($faker->email);
$utilisateur->setPass($faker->password);
$utilisateur->set_is_Banned($faker->boolean);
$utilisateur->set_is_Admin($faker->boolean);
$utilisateur->setNumTel($faker->randomNumber(8));

$manager->persist($utilisateur);
    $manager->flush();
}

}
}