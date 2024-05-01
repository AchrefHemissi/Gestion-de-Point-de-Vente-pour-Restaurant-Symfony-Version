<?php

namespace App\Controller;
use App\Form\AdminMailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{


    #[Route('/admin/dashboard', name: 'send_email')]
    public function sendEmail(Request $request): Response
    {
        $form = $this->createForm(AdminMailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $recipient = $formData['recipient'];
            $subject = $formData['subject'];
            $message = $formData['message'];
            $email = (new \Symfony\Component\Mime\Email())
                ->from('your@example.com')
                ->to($recipient)
                ->subject($subject)
                ->text($message);

            $mailer = $this->get('mailer');
            $mailer->send($email);

            // Redirect or display success message
            $this->addFlash('success', 'Email sent successfully.');

        }

        return $this->render('admin/dashboard.html.twig', [
            'eform' => $form->createView(),
        ]);


    }
}
