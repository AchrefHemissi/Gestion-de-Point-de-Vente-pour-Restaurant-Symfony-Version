<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FastFoodController extends AbstractController
{
    #[Route('/fast/food', name: 'fast_food')]
    public function index(): Response
    {
        return $this->render('fast_food/index.html.twig', [
            'controller_name' => 'FastFoodController',
        ]);
    }
}
