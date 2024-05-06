<?php

namespace App\Controller;

use App\Entity\Commande;
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
        $session=$request->getSession();
        $person=$repository->findOneBy(['id'=>$session->get('id')]);
        if(!$person)
            return $this->redirectToRoute('login_page');
        $order=new Commande();
        $paymentdata=$session->get('payment_data');
        $orderdate=new \DateTime($paymentdata['date']);
        $orderaddress=$paymentdata['address'];
        $order->setLieu($orderaddress);
        $order->setDateCommande($orderdate);
        $order->setIdClient($person);
        $order->setEtatCommande(0);
        $entityManager->persist($order);
        $entityManager->flush();
        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }
}
