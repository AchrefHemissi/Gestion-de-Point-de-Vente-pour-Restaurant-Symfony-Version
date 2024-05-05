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

        if(!$person)
            return $this->redirectToRoute('login_page');


        $form=[];
        for($i=0;$i<10;$i++) {
            $form[] =$this->createForm(ProductType::class);
        }
        for($i=0;$i<10;$i++) {
                $form[$i]->handleRequest($request);
                if ($form[$i]->isSubmitted() && $form[$i]->isValid()) {
                return $this->add($request, $form[$i], $manager);
            }

        }




        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'form' => $form[0]->createView(),
            'form1' => $form[1]->createView(),
            'form2' => $form[2]->createView(),
            'form3' => $form[3]->createView(),
            'form4' => $form[4]->createView(),
            'form5' => $form[5]->createView(),
            'form6' => $form[6]->createView(),
            'form7' => $form[7]->createView(),
            'form8' => $form[8]->createView(),
            'form9' => $form[9]->createView()


        ]);
    }
    public function add(Request $request,$form,EntityManagerInterface $manager):Response
    {
        $session=$request->getSession();
        $cart=$session->get('cart');
        $formdata=$form->getData();
        $product=$manager->getRepository(Produit::class)->findOneBy(['id'=>$formdata['id']]);
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
