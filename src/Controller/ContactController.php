<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {   $contactform = $this->createForm(ContactType::class);
        $contactform->handleRequest($request);
        if ($contactform->isSubmitted() && $contactform->isValid()) {
            $email=$contactform->getData('email');
            $message=$contactform->getData('message');
            $this->addFlash('success', 'Thanks for contacting us! We will get back to you shortly.');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $contactform->createView(),
        ]);
    }
}
