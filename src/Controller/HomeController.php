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
        $admin=$session->get('admin');
        if(!$person)
            return $this->redirectToRoute('login_page');
        if($admin)
            return $this->redirectToRoute('dashboard');
        if($session->get('cart') == null){
            $session->set('cart',[]);
        }

        $form = $this->createForm(ProductType::class);




        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'person' => $person,
            'form' => $form->createView(),
            'form1' => $form->createView(),
            'form2' => $form->createView(),
            'form3' => $form->createView(),
            'form4' => $form->createView(),
            'form5' => $form->createView()
        ]);
    }



}
