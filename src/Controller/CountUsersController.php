<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CountUsersController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/count-users', name: 'count_users')]
    public function countUsers(): Response
    {
        $query = $this->em->createQueryBuilder()
            ->select('count(u.id)')
            ->from('App\Entity\Utilisateur', 'u')
            ->where('u.is_admin = 0')
            ->getQuery();

        $total = $query->getSingleScalarResult();

        return new Response($total);
    }
}
