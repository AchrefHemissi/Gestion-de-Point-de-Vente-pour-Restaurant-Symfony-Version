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


        return $this->render('fast_food/index.html.twig', [
            'controller_name' => 'FastFoodContollerController',
            'form' => $form->createView(),
            'form2' => $form->createView(),
            'form6' => $form->createView(),
            'form7' => $form->createView()
        ]);


    }




}
