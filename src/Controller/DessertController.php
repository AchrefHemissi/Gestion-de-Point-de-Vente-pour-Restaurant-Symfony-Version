<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DessertController extends AbstractController
{
    #[Route('/dessert', name: 'dessert')]
    public function index(): Response
    {
        return $this->render('dessert/index.html.twig', [
            'controller_name' => 'DessertController',
        ]);
    }
}
