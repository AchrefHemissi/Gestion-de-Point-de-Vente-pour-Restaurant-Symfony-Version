<?php

namespace App\Controller;

use App\Entity\CarteBancaire;
use App\Form\PaymentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function pay(Request $request, EntityManagerInterface $entityManager): Response
    {
        //il ya un form qui contient les address dans checkout
        //il faut le recuperer ici pour l'envoyer a la base de donnee     -sahbi was head
        $session = $request->getSession();
        $person = $session->get('id');
        $checkoutData = $session->get('checkout_data');
        if (!$checkoutData) {
            return $this->redirectToRoute('checkout');
        }
        if (!$person) {
            return $this->redirectToRoute('login_page');
        }

        $paymentform = $this->createForm(PaymentType::class);
        $paymentform->handleRequest($request);
        $address = $checkoutData['address'];
        $paymentMethod = $checkoutData['payment_method'];
        $totalPrice = $checkoutData['totalprice'];
        if ($paymentform->isSubmitted() && $paymentform->isValid()) {
            $number = $paymentform->get('numero')->getData();
            $code = $paymentform->get('code')->getData();
            $card = $entityManager->getRepository(CarteBancaire::class)->findOneBy(['numero' => $number]);
            if (!$card) {
                $this->addFlash('danger', 'Invalid credentials.');
            } else {
                $expectedCode = $card->getCode();

                if ($expectedCode != $code) {
                    $this->addFlash('danger', 'Invalid credentials.');
                } else {
                    $availableBalance = $card->getMontant();
                    var_dump($availableBalance);
                    if ($availableBalance < $totalPrice) {
                        $this->addFlash('danger', 'Insufficient funds.');
                    } else {
                        // Process the payment (simulate success here)
                        $this->addFlash('success', 'Payment successful');
                        $newBalance = $availableBalance - $totalPrice;
                        $card->setMontant($newBalance);
                        $entityManager->persist($card);
                        $entityManager->flush();
                        return $this->redirectToRoute('home');
                    }
                }
            }
        }
        return $this->render('payment/payment.html.twig', [
            'total' => $totalPrice,
            'form' => $paymentform->createView(),

        ]);
    }
}
