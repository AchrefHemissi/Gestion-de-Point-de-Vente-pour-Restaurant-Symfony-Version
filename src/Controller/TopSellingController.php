<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

class TopSellingController extends AbstractController
{

    #[Route('/top-selling', name: 'top_selling')]
    public function topSelling(ManagerRegistry $doctrine): JsonResponse
    {
        $repository = $doctrine->getRepository(Produit::class);

        // Fetch top 3 'Produit' entities ordered by 'vendu' field

        $produits = $repository->findBy([], ['vendu' => 'DESC'], 3);

        // Extract the 'name' and 'vendu' fields from each 'Produit'
        $data = array_map(function($produit) {
            return [
                'name' => $produit->getName(),
                'vendu' => $produit->getVendu()
            ];
        }, $produits);

        return new JsonResponse($data);
    }
}
