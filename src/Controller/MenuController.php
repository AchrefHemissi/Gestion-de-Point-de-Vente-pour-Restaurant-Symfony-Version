<?php

namespace App\Controller;


use App\Form\ProductType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{

    #[Route('/menu', name: 'menu')]
    public function index( Request $request ): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form->createView()

        ]);
    }
}
