<?php

namespace App\Controller;

use App\Form\AdminMailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/admin/dashboardh', name: 'send_email')]
    public function sendEmail(Request $request): Response
    {
        $form = $this->createForm(AdminMailType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $recipient = $formData['recipient'];
            $subject = $formData['subject'];
            $message = $formData['message'];
            $email = (new Email())
                ->from('your@example.com')
                ->to($recipient)
                ->subject($subject)
                ->text($message);

            $this->mailer->send($email);

            // Redirect or display success message
            $this->addFlash('success', 'Email sent successfully.');
        }

        return $this->render('admin/dashboard.html.twig', [
            'eform' => $form->createView(),
        ]);
    }
}