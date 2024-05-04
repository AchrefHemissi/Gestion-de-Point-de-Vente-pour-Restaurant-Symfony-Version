<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
        {
            return $this->redirectToRoute('login_page');
        }
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            
        ]);
    }
}
