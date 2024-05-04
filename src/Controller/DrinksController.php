<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DrinksController extends AbstractController
{
    #[Route('/drinks', name: 'drinks')]
    public function index(): Response
    {
        return $this->render('drinks/index.html.twig', [
            'controller_name' => 'DrinksController',
        ]);
    }
}
