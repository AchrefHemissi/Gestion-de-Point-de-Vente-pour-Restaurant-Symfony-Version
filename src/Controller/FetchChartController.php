<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class FetchChartController extends AbstractController
{

    #[Route('/fetch-chart', name: 'fetch_chart')]
    public function fetchChart(ManagerRegistry $doctrine): JsonResponse
    {

        $repository = $doctrine->getRepository(Produit::class);

        // Fetch all 'products' entities
        $products = $repository->findAll();

        // Extract the 'vendu' field from each 'product'
        $data = array_map(function($products) {
            return $products->getVendu();
        }, $products);

        return new JsonResponse($data);
    }
}
