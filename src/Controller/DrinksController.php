<?php

namespace App\Controller;


use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DrinksController extends AbstractController
{
    #[Route('/drinks', name: 'drinks')]
    public function index(Request $request): Response
    {

        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');


        $form8 = $this->createForm(ProductType::class);  //mojito
        $form8->handleRequest($request);
        if ($form8->isSubmitted() && $form8->isValid()) {
            return $this->add($request, $form8);
        }


        $form4 = $this->createForm(ProductType::class); //orange juice
        $form4->handleRequest($request);
        if ($form4->isSubmitted() && $form4->isValid()) {
            return $this->add($request, $form4);
        }



        return $this->render('drinks/index.html.twig', [
            'controller_name' => 'DrinksController',
            'form8' => $form8->createView(),
            'form4' => $form4->createView()
        ]);

    }



    public function add(Request $request, $form):Response
    {
        $session=$request->getSession();
        $cart=$session->get('cart');
        $cart[]=[
            'id'=>$form->get('id')->getData(),
            'quantity'=>$form->get('quantity')->getData()
        ];
        $session->set('cart',$cart);
        return $this->redirectToRoute('cart');
    }

}
