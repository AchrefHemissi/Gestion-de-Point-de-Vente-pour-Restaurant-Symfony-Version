<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FetchChartController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/fetch-chart', name: 'fetch_chart')]
    public function fetchChart(): JsonResponse
    {
        $repository = $this->em->getRepository(Produit::class);

        // Fetch all 'Produit' entities
        $produits = $repository->findAll();

        // Extract the 'vendu' field from each 'Produit'
        $data = array_map(function($produit) {
            return $produit->getVendu();
        }, $produits);

        return new JsonResponse($data);
    }
}
