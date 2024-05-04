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
        $session=$request->getSession();
        $cart=$session->get('cart');
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        $form1 = $this->createForm(ProductType::class);
        $form1->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            return $this->add($request, $form);
        }

        if ($form1->isSubmitted() && $form1->isValid()) {

            return $this->add($request, $form1);
        }





        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form->createView(),
            'form1' => $form1->createView()

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

    private function path(string $string, array $array)
    {
    }
}
