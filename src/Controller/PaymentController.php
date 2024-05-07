<?php

namespace App\Controller;

use App\Entity\CarteBancaire;
use App\Entity\Commande;
use App\Entity\OrdProduit;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\PaymentType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function pay(Request $request, EntityManagerInterface $entityManager): Response
    {

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
                        $status = $this->addDataBase($request,$entityManager);
                        // Process the payment (simulate success here)
                        if(!$status)
                            {
                                $this->addFlash('paymentdanger', 'data base not available');
                            }
                        else{
                            $this->addFlash('paymentsuccess', 'Payment successful');
                            $newBalance = $availableBalance - $totalPrice;
                            $card->setMontant($newBalance);
                            $entityManager->persist($card);
                            $entityManager->flush();
                            $session->set('cart',[]);
                            $session->set('checkout_data',[]);

                            return $this->redirectToRoute('orders');
                        }
                    }
                }
            }
        }

        return $this->render('payment/payment.html.twig', [
            'total' => $totalPrice,
            'form' => $paymentform->createView(),

        ]);
    }
    private function addDataBase(Request $request,EntityManagerInterface $entityManager):bool
    {
        try {
            $repository = $entityManager->getRepository(Utilisateur::class);
            $ordproductrepo = $entityManager->getRepository(OrdProduit::class);
            $commandeRepository = $entityManager->getRepository(Commande::class);
            $productrepo=$entityManager->getRepository(Produit::class);

            // Check if 'id' and 'payment_data' exist in the session
            if (!$request->getSession()->has('id') || !$request->getSession()->has('checkout_data')) {
                // Handle the case where session data is missing
                return false;
            }

            $session = $request->getSession();
            $cart=$session->get('cart');
            $user=$repository->findOneBy(['id'=>$session->get('id')]);
            $orderaddress = $request->getSession()->get('checkout_data')['address'];
            $today = new \DateTime();
            $formattedDate = $today->format('Y-m-d');

            $order = new Commande();
            $order->setLieu($orderaddress);
            $order->setDateCommande($today);
            $order->setIdClient($user);
            $order->setEtatCommande(0);
            $entityManager->persist($order);
            $entityManager->flush();

            foreach($cart as $id => $item){
                $ordproduct=new OrdProduit();
                $product=$productrepo->findOneBy(['id'=>$id]);

                $ordproduct->setIdCommande($order);
                $ordproduct->setIdProduit($product);
                $ordproduct->setQuantity($item['quantity']);
                $product ->setVendu($product->getVendu()+$item['quantity']);

                $order->addOrdProduit($ordproduct);

                $entityManager->persist($ordproduct);
                $entityManager->persist($product);

            }

            $entityManager->persist($order);
            $entityManager->flush();



            // Return true if the operation is successful
            return true;
        } catch (\Exception $e) {


            return false;
        }
    }
}
