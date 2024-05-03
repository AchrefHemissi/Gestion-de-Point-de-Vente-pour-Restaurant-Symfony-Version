<?php

namespace App\Controller;

use App\Entity\Utilisateur;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

class CountUsersController extends AbstractController
{

    #[Route('/count-users', name: 'count_users')]
    public function countUsers(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Utilisateur::class);
        $total = $repository->countUsers();

        return new Response($total);
    }
}
