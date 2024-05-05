<?php

namespace App\Controller;


use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DessertController extends AbstractController
{
    #[Route('/dessert', name: 'dessert')]
    public function index(Request $request): Response
    {

        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');


        $form= $this->createForm(ProductType::class);  //cheese cake

        return $this->render('dessert/index.html.twig', [
            'controller_name' => 'DessertController',
            'form3' => $form->createView(),
            'form9' => $form->createView()
        ]);

    }





}
