<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\OrdProduit;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrdersController extends AbstractController
{
    #[Route('/orders', name: 'orders')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {   $repository = $entityManager->getRepository(Utilisateur::class);
        $repositoryCommande = $entityManager->getRepository(Commande::class);
        $repositoryOrdProduct = $entityManager->getRepository(OrdProduit::class);
        $repositoryProduct = $entityManager->getRepository(Produit::class);
        $session=$request->getSession();
        $person=$repository->findOneBy(['id'=>$session->get('id')]);
        if(!$person)
            return $this->redirectToRoute('login_page');

        $commande=  $repositoryCommande->findBy(['id_client' => $person]);
        $ordProduct =$repositoryOrdProduct->findAll();
        $user= $repository->findOneBy(['id' => $person->getId()]);
        $name= $user->getNom();
        $email= $user->getEmail();
        $orders = [];

        foreach ($commande as $item) {
            $order = [];
            $order['order_date'] = $item->getDateCommande()->format('Y-m-d ');
            $order['order_address'] = $item->getLieu();
            $order['customer_name'] = $name;
            $order['customer_email'] = $email;
            $order['products'] = [];

            $totalPrice = 0;

            foreach ($item->getOrdProduits() as $ordProduit) {
                $product = $repositoryProduct->findOneBy(['id' => $ordProduit->getIdProduit()]);
                $productName = $product->getName();
                $productPrice = $product->getPrix();
                $quantity = $ordProduit->getQuantity();
                $totalPrice += $productPrice * $quantity;

                $order['products'][] = [
                    'name' => $productName,
                    'quantity' => $quantity,
                    'unit_price' => $productPrice
                ];
            }

            $order['total_price'] = $totalPrice;

            $orders[] = $order;
        }

        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
            'orders' => $orders
        ]);
    }
}
