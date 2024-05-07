<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FetchOrdProductController extends AbstractController
{
    #[Route('/fetch/ord/product', name: 'app_fetch_ord_product')]
    public function index(): Response
    {
        return $this->render('fetch_ord_product/index.html.twig', [
            'controller_name' => 'FetchOrdProductController',
        ]);
    }
}
