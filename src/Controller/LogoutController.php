<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function index(Request $request): Response
    {   
        $session = $request->getSession();
        if ($session->has('id')) {
            $session->remove('id');
        }
        if($session->has('cart')){
            $session->remove('cart');
        } // reset cart
        if($session->has('checkout_data')){
            $session->remove('checkout_data');
        } // reset checkout_data


        return $this->redirectToRoute('login_page');
    }
}
