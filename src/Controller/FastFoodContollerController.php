<?php

namespace App\Controller;


use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FastFoodContollerController extends AbstractController
{
    #[Route('/fast/food', name: 'fast_food')]
    public function index(Request $request): Response
    {

        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');
        $form = $this->createForm(ProductType::class);  //pizza
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->add($request, $form);
        }


        $form2 = $this->createForm(ProductType::class); //burger
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            return $this->add($request, $form2);
        }

        $form6 = $this->createForm(ProductType::class); //fried chicken
        $form6->handleRequest($request);
        if ($form6->isSubmitted() && $form6->isValid()) {
            return $this->add($request, $form6);
        }


        $form7 = $this->createForm(ProductType::class); //fried chicken
        $form7->handleRequest($request);
        if ($form7->isSubmitted() && $form7->isValid()) {
            return $this->add($request, $form7);
        }

        return $this->render('fast_food/index.html.twig', [
            'controller_name' => 'FastFoodContollerController',
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'form6' => $form6->createView(),
            'form7' => $form7->createView()
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
