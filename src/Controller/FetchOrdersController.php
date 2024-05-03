<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class FetchOrdersController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/fetch-orders', name: 'fetch_orders')]
    public function fetchOrders(): JsonResponse
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('c.id as cid', 'c.date_commande as cdate', 'c.lieu as clieu', 'u.nom as lname', 'u.prenom as fname', 'u.num_tel as unum_tel', 'p.name as prod', 'o.quantity as quan')
            ->from('App\Entity\Commande', 'c')
            ->join('App\Entity\Utilisateur', 'u', 'WITH', 'u.id = c.id_client')
            ->join('App\Entity\Ordproduit', 'o', 'WITH', 'o.id_commande = c.id')
            ->join('App\Entity\Produit', 'p', 'WITH', 'p.id = o.id_produit')
            ->where('c.etat_commande = 0')
            ->orderBy('c.id', 'ASC');

        $query = $qb->getQuery();
        $orders = $query->getResult();
        // Group orders by their ID
        $groupedOrders = [];
        foreach ($orders as $order) {
            $groupedOrders[$order['cid']][] = $order;
        }

        return new JsonResponse($groupedOrders);
    }

}
