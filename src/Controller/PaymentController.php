<?php

namespace App\Controller;

use App\Entity\CarteBancaire;
use App\Entity\Commande;
use App\Entity\Utilisateur;
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
        $repository = $entityManager->getRepository(Utilisateur::class);
        $session = $request->getSession();
        $person=$repository->findOneBy(['id'=>$session->get('id')]);
        $checkoutData = $session->get('checkout_data');
        $today = new \DateTime();
        $formattedDate = $today->format('Y-m-d');

        if (!$checkoutData) {
            return $this->redirectToRoute('checkout');
        }
        if (!$person) {
            return $this->redirectToRoute('login_page');
        }

        $paymentform = $this->createForm(PaymentType::class);
        $paymentform->handleRequest($request);
        $address = $checkoutData['address'];
        $totalPrice = $checkoutData['totalprice'];
        if ($paymentform->isSubmitted() && $paymentform->isValid()) {
            $number = $paymentform->get('numero')->getData();
            $code = $paymentform->get('code')->getData();
            $card = $entityManager->getRepository(CarteBancaire::class)->findOneBy(['numero' => $number]);
            if (!$card) {
                $this->addFlash('paymentdanger', 'Invalid credentials.');
            } else {
                $expectedCode = $card->getCode();

                if ($expectedCode != $code) {
                    $this->addFlash('paymentdanger', 'Invalid credentials.');
                } else {
                    $availableBalance = $card->getMontant();
                    if ($availableBalance < $totalPrice) {
                        $this->addFlash('paymentdanger', 'Insufficient funds.');
                    } else {
                        // Process the payment (simulate success here)
                        $this->addFlash('paymentsuccess', 'Payment successful');
                        $newBalance = $availableBalance - $totalPrice;
                        $card->setMontant($newBalance);
                        $entityManager->persist($card);
                        $entityManager->flush();
                        $session->set('payment_data',[
                            'address'=>$address,
                            'date'=>$formattedDate,
                            'id_client'=>$person->getId()
                        ]);

                        return $this->redirectToRoute('orders');
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
