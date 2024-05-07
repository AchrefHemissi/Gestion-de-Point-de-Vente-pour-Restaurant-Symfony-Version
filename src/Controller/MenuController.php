<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Form\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{

#[Route('/menu', name: 'menu')]
    public function index( Request $request,EntityManagerInterface $manager ): Response
    {
        $session=$request->getSession();
        $person=$session->get('id');

        if(!$person) {
            return $this->redirectToRoute('login_page');
        }

        $form =$this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                return $this->add($request, $form, $manager);
        }


        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form->createView(),
            'form1' => $form->createView(),
            'form2' => $form->createView(),
            'form3' => $form->createView(),
            'form4' => $form->createView(),
            'form5' => $form->createView(),
            'form6' => $form->createView(),
            'form7' => $form->createView(),
            'form8' => $form->createView(),
            'form9' => $form->createView()


        ]);
    }
    public function add(Request $request,$form,EntityManagerInterface $manager):Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart');
        $formdata = $form->getData();
        $product = $manager->getRepository(Produit::class)->findOneBy(['id' => $formdata['id']]);
        if ($formdata['quantity'] <= 0 || $formdata['quantity'] > 99 || !is_int($formdata['quantity'])){
            $this->addFlash('error', "Invalid quantity! please dont touch the html");
            return $this->redirectToRoute('menu');
        }
        //$form -> getData()['id'] // $form->get('id')->getData()
        $cart[$product->getId()]=[
            'id'=>$product->getId(),
            'name'=>$product->getName(),
            'price'=>$product->getPrix(),
            'imgPath'=>$product->getImgPath(),
            'quantity'=>$formdata['quantity']
        ];
        $session->set('cart',$cart);
        return $this->redirectToRoute('cart');
    }

    private function path(string $string, array $array)
    {
    }
}
