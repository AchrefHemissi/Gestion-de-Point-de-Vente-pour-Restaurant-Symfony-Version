<?php
// src/Controller/Page1Controller.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{

      #[Route('auth/login', name:"login_route")]

    public function index(): Response
    {
        return $this->render('auth/login.html.twig');
    }
}
