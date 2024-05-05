<?php

namespace App\Controller;

use App\Service\SendMailFromAdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'contact')]
    public function index(Request $request,SendMailFromAdminService $mailer): Response

    {
        $contactform = $this->createForm(ContactType::class);
        $contactform->handleRequest($request);

        if($request->isMethod('Post')) {

            if ($contactform->isSubmitted() && $contactform->isValid()) {

                $formData = $contactform->getData();

                if($mailer->sendEmail('gl.icious.symfonyteam@gmail.com','Feedback From: '.$formData['email'],$formData['message'],'gl.icious.symfonyteam@gmail.com')) {

                    $this->addFlash('success', 'Thanks for contacting us! We will get back to you shortly.');
                }

                else {

                    $this->addFlash('danger', "We're sorry, but we were unable to send your message at this time. Please try again later.");
                }

                return  $this ->redirectToRoute('contact');
            }

            else {

                $this->addFlash('danger', "We're sorry, but your form submission is not valid. Please check the fields and try again.");
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $contactform->createView(),
        ]);
    }
}
