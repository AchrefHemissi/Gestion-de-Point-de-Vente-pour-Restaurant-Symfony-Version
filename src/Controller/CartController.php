<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(Request $request): Response
    {
        $request->getSession()->get('cart');
        $session = $request->getSession();
        $id = $session->get('id');
        if(!$id)
            return $this->redirectToRoute('login_page');
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/cart/delete/{id}', name: 'cart.delete')]
    public function delete(Request $request,int $id): Response
    {

        $session = $request->getSession();
        $cart = $session->get('cart');
        if($id)
        {
            unset($cart[$id]);
            $session->set('cart', $cart);
        }

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
