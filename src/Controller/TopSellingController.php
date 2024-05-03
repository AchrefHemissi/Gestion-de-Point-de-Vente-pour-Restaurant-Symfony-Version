<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TopSellingController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/top-selling', name: 'top_selling')]
    public function topSelling(): JsonResponse
    {
        $repository = $this->em->getRepository(Produit::class);

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
