<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(UtilisateurRepository $userRepository,Request $request): Response
    {
        // Start a session and set some data
        $session = $request->getSession();
        $users = $userRepository->findAll();
        // Render the 'dashboard.twig' template
        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
        ]);
    }

}