<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(): Response
    {

        $pageTitle = 'Admin Dashboard';

        return $this->render('admin/dashboard.html.twig', [
            'page_title' => $pageTitle,
            // Add more variables as needed
        ]);
    }


}
