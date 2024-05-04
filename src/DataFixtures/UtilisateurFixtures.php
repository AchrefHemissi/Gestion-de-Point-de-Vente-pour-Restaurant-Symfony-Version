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

for ($i = 0; $i < 10; $i++) {
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

    $utilisateur = new Utilisateur();
    $utilisateur->setNom("admin");
    $utilisateur->setPrenom("admin");
    $utilisateur->setEmail("admin@gmail.com");
    $utilisateur->setPass("admin");
    $utilisateur->set_is_Banned(0);
    $utilisateur->set_is_Admin(1);
    $utilisateur->setNumTel(11111111);
    $manager->persist($utilisateur);
    $manager->flush();

    $utilisateur = new Utilisateur();
    $utilisateur->setNom("customer");
    $utilisateur->setPrenom("customer");
    $utilisateur->setEmail("customer@gmail.com");
    $utilisateur->setPass("customer");
    $utilisateur->set_is_Banned(0);
    $utilisateur->set_is_Admin(0);
    $utilisateur->setNumTel(22222222);
    $manager->persist($utilisateur);
    $manager->flush();

}

}