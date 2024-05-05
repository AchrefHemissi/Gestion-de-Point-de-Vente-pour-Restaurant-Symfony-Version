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

        $produit = new Produit();
        $produit->setName("Pizza");
        $produit->setPrix("10");
        $produit->setVendu(0);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/uploaded_img/pizza-1.png");
        $manager->persist($produit);
        $manager->flush();



        $produit = new Produit();
        $produit->setName("Spaghetti");
        $produit->setPrix(8);
        $produit->setVendu(5);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/images/spaghetti.jpg");
        $manager->persist($produit);
        $manager->flush();




        $produit = new Produit();
        $produit->setName("Hamburger");
        $produit->setPrix(9);
        $produit->setVendu(1);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/uploaded_img/burger-1.png");
        $manager->persist($produit);
        $manager->flush();


        $produit = new Produit();
        $produit->setName("Chesscake");
        $produit->setPrix(7);
        $produit->setVendu(0);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/images/cheesecake.jpg");
        $manager->persist($produit);
        $manager->flush();




        $produit = new Produit();
        $produit->setName("Orange Juice");
        $produit->setPrix(3);
        $produit->setVendu(2);
        $produit->set_is_Drink(1);
        $produit->setImgPath("client/uploaded_img/drink-1.png");
        $manager->persist($produit);
        $manager->flush();





        $produit = new Produit();
        $produit->setName("Chawarma");
        $produit->setPrix(6);
        $produit->setVendu(4);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/images/chawarma.avif");
        $manager->persist($produit);
        $manager->flush();

        $produit = new Produit();
        $produit->setName("Fries");
        $produit->setPrix(2);
        $produit->setVendu(0);
        $produit->set_is_Drink(0);
        $produit->setImgPath('client/images/fries.jpg');

        $manager->persist($produit);
        $manager->flush();


        $produit = new Produit();
        $produit->setName("FriedChiken");
        $produit->setPrix(12);
        $produit->setVendu(0);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/images/FriedChicken.jpg");

        $manager->persist($produit);
        $manager->flush();


        $produit = new Produit();
        $produit->setName("Mojito");
        $produit->setPrix(5);
        $produit->setVendu(0);
        $produit->set_is_Drink(1);
        $produit->setImgPath("client/images/mojito.avif");
        $manager->persist($produit);
        $manager->flush();


        $produit = new Produit();
        $produit->setName("Tiramisu");
        $produit->setPrix(11);
        $produit->setVendu(1);
        $produit->set_is_Drink(0);
        $produit->setImgPath("client/uploaded_img/dessert-2.png");
        $manager->persist($produit);
        $manager->flush();

    }

    public function getGroups(): array
    {
        return ['produit'];
    }
}