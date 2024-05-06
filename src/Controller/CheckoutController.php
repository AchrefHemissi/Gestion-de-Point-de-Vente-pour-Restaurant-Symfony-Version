<?php

namespace App\Controller;

use App\Form\CheckoutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart');
        if(!$cart)
            return $this->redirectToRoute('cart');
        $totalprice = 0;
        foreach($cart as $item)
        {
            $totalprice += $item['price']* $item['quantity'];
        }
        $session->set('checkout_data', [
            'address' => '',
            'payment_method' => '',
            'totalprice' => $totalprice,
        ]);
        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $session->set('checkout_data', [
                'address' => $formData['address'],
                'payment_method' => $formData['method'],
                'totalprice' => $totalprice,
            ]);

            return $this->redirectToRoute('payment');
        }

        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckoutController',
            'form' => $form->createView(),
            'totalprice' => $totalprice,
        ]);
    }
}
