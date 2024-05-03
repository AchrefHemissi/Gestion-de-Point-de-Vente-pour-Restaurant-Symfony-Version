<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Utilisateur::class);
        $users = $repository->findAll();

        return $this->render('admin/dashboard.html.twig', ['users' => $users]);
    }

}