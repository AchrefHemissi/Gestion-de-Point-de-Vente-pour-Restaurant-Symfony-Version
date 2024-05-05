<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\CartFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');
        if(!$session->get('cart') !== null){
            $session->set('cart',[]);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'person' => $person
        ]);
    }
}
