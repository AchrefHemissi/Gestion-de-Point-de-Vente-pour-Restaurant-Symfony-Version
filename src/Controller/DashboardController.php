<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\AdminMailType;
use App\Service\SendMailFromAdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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

        $form = $this->generateForm($request);

        if($request->isMethod('Post'))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $formData = $form->getData();

                //send  the mail to the user
                if($mailer->sendEmail($formData['recipient'],$formData['subject'],$formData['message'],'gl.icious.symfonyteam@gmail.com'))
                {
                    $this->addFlash('success', 'Email sent successfully.');
                }
                else {
                    $this->addFlash('danger', "We're sorry, but we were unable to send your message at this time. Please try again later.");
                }

                return  $this ->redirectToRoute('dashboard');
            }
            else {

                $this->addFlash('danger', "We're sorry, but your form submission is not valid. Please check the fields and try again.");

            }
        }

        return $this->render('admin/dashboard.html.twig', ['users' => $users, 'form' => $form->createView()]);
    }

    public function generateForm(Request $request): FormInterface
    {
        $form = $this->createForm(AdminMailType::class);
        $form->handleRequest($request);

        return $form;
    }
}