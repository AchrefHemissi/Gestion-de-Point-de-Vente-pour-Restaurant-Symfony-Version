<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'about')]
    public function index(Request $request): Response
    {   $session = $request->getSession();
        $id = $session->get('id');
        if(!$id)
            return $this->redirectToRoute('login_page');

        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
