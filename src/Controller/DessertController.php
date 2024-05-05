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


        $form3 = $this->createForm(ProductType::class);  //cheese cake
        $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            return $this->add($request, $form3);
        }


        $form9 = $this->createForm(ProductType::class); //tiramisu
        $form9->handleRequest($request);
        if ($form9->isSubmitted() && $form9->isValid()) {
            return $this->add($request, $form9);
        }



        return $this->render('dessert/index.html.twig', [
            'controller_name' => 'DessertController',
            'form3' => $form3->createView(),
            'form9' => $form9->createView()
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
