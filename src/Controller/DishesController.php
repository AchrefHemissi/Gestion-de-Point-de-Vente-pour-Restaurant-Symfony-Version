<?php

namespace App\Controller;


use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DishesController extends AbstractController
{
    #[Route('/dishes', name: 'dishes')]
    public function index(Request $request): Response
    {

        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');

        $form1 = $this->createForm(ProductType::class);  //spaghetti
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            return $this->add($request, $form1);
        }


        $form5 = $this->createForm(ProductType::class); //chawarma
        $form5->handleRequest($request);
        if ($form5->isSubmitted() && $form5->isValid()) {
            return $this->add($request, $form5);
        }



        return $this->render('dishes/index.html.twig', [
            'controller_name' => 'DishesController',
            'form1' => $form1->createView(),
            'form5' => $form5->createView()
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
