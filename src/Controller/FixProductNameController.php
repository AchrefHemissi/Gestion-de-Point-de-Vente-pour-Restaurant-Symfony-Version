<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FixProductNameController extends AbstractController
{
    #[Route('/fix/product/name', name: 'app_fix_product_name')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Produit::class)->findAll();


        $product4=$products[3];
        $product4->setName('Cheese Cake');
        $entityManager->persist($product4);

        $product8=$products[7];
        $product8->setName('Fried Chicken');
        $entityManager->persist($product8);

        $entityManager->flush();


        return $this->render('fix_product_name/index.html.twig', [
            'controller_name' => 'FixProductNameController',
        ]);
    }
}
