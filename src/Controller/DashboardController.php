<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\AdminMailType;
use App\Service\SendMailFromAdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;


class DashboardController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(ManagerRegistry $doctrine,Request $request,SendMailFromAdminService $mailer): Response
    {
        $repository = $doctrine->getRepository(Utilisateur::class);
        $users = $repository->findAll();

        $form = $this->generateForm($request, $mailer);

        return $this->render('admin/dashboard.html.twig', ['users' => $users, 'form' => $form]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function generateForm(Request $request, SendMailFromAdminService $mailer): FormView
    {
        $form = $this->createForm(AdminMailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            //send  the mail to the user
            $mailer->sendEmail($formData);
            $this->addFlash('success', 'Email sent successfully.');
            // Clear the form
            $form = $this->createForm(AdminMailType::class);

        }
        $this->addFlash('failed', "Email wasn't send");
        return $form->createView();
    }

}