<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

class UpdateOrdersController extends AbstractController
{
    #[Route('/update-orders/{id}', name: 'update_orders')]
    public function updateOrders($id,ManagerRegistry $doctrine): JsonResponse
    {
        $repository = $doctrine->getRepository(Commande::class);

        // Fetch the 'Commande' entity with the given id
        $commande = $repository->find($id);

        if (!$commande) {
            throw $this->createNotFoundException('No commande found for id '.$id);
        }

        // Update 'etat_commande' to 1

        $commande->setEtatCommande(1);
        $manager = $doctrine->getManager();
        $manager->persist($commande);
        $manager->flush();

        return new JsonResponse(['status' => 'success']);
    }
}
