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

        $form1 = $this->createForm(ProductType::class);
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            dd($form1->getData());
        }

        $form2 = $this->createForm(ProductType::class);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            dd($form2->getData());
        }

        $form3 = $this->createForm(ProductType::class);
        $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            dd($form3->getData());
        }

        $form4 = $this->createForm(ProductType::class);
        $form4->handleRequest($request);
        if ($form4->isSubmitted() && $form4->isValid()) {
            dd($form4->getData());
        }

        $form5 = $this->createForm(ProductType::class);
        $form5->handleRequest($request);
        if ($form5->isSubmitted() && $form5->isValid()) {
            dd($form5->getData());
        }

        $form6 = $this->createForm(ProductType::class);
        $form6->handleRequest($request);
        if ($form6->isSubmitted() && $form6->isValid()) {
            dd($form6->getData());
        }


        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'form4' => $form3->createView(),
            'form5' => $form3->createView(),
            'form6' => $form3->createView()


        ]);
    }
}
