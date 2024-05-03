<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class FetchOrdersController extends AbstractController
{
    #[Route('/fetch-orders', name: 'fetch_orders')]
    public function fetchOrders(ManagerRegistry $doctrine): JsonResponse
    {
        $repository = $doctrine->getRepository(Commande::class);

        $orders = $repository->fetchOrders();

        // Group orders by their ID
        $groupedOrders = [];
        foreach ($orders as $order) {
            $groupedOrders[$order['cid']][] = $order;
        }
        return new JsonResponse($groupedOrders);
    }

}
