<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FastFoodContollerController extends AbstractController
{
    #[Route('/fast/food/contoller', name: 'fast_food')]
    public function index(): Response
    {
        return $this->render('fast_food_contoller/index.html.twig', [
            'controller_name' => 'FastFoodContollerController',
        ]);
    }
}
