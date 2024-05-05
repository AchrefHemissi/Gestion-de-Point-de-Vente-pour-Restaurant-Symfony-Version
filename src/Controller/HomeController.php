<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\CartFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ProductType;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');
        if($session->get('cart') == null){
            $session->set('cart',[]);
        }

        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->add($request, $form);
        }

        $form1 = $this->createForm(ProductType::class);
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            return $this->add($request, $form1);
        }

        $form2 = $this->createForm(ProductType::class);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            return $this->add($request, $form2);
        }

        $form3 = $this->createForm(ProductType::class);
        $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            return $this->add($request, $form3);
        }

        $form4 = $this->createForm(ProductType::class);
        $form4->handleRequest($request);
        if ($form4->isSubmitted() && $form4->isValid()) {
            return $this->add($request, $form4);
        }

        $form5 = $this->createForm(ProductType::class);
        $form5->handleRequest($request);
        if ($form5->isSubmitted() && $form5->isValid()) {
            return $this->add($request, $form5);
        }




        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'person' => $person,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'form4' => $form3->createView(),
            'form5' => $form3->createView()
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
