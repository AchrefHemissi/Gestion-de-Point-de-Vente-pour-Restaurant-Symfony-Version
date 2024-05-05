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

        $form = $this->createForm(ProductType::class);  //spaghetti



        return $this->render('dishes/index.html.twig', [
            'controller_name' => 'DishesController',
            'form1' => $form->createView(),
            'form5' => $form->createView()
        ]);


    }





}
