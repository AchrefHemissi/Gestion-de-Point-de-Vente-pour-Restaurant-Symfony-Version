<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DishesController extends AbstractController
{
    #[Route('/dishes', name: 'dishes')]
    public function index(): Response
    {
        return $this->render('dishes/index.html.twig', [
            'controller_name' => 'DishesController',
        ]);
    }
}
