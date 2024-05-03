<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UpdateOrdersController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
     {
            $this->em = $em;
     }


    #[Route('/update-orders/{id}', name: 'update_orders')]
    public function updateOrders($id): JsonResponse
    {
        // Fetch the 'Commande' entity with the given id
        $commande = $this->em->getRepository('App\Entity\Commande')->find($id);

        if (!$commande) {
            throw $this->createNotFoundException('No commande found for id '.$id);
        }

        // Update 'etat_commande' to 1
        $commande->setEtatCommande(1);

        $this->em->persist($commande);

        $this->em->flush();

        return new JsonResponse(['status' => 'success']);
    }
}
