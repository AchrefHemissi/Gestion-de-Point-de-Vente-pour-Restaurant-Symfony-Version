<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ToggleUserController extends AbstractController
{
    #[Route('/toggle-user/{id}', name: 'toggle_user', methods: ['POST'])]
    public function toggleUser($id, UtilisateurRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        // Toggle the user's status
        $user->set_is_Banned($user->get_is_Banned() == 0 ? 1 : 0);

        // Save the changes to the database
        $em->persist($user);
        $em->flush();

        // Return the new status as a response
        return new JsonResponse(['status' => $user->get_is_Banned()]);
    }

}
