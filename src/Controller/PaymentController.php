<?php
namespace App\Controller;
use App\Entity\CarteBancaire;
use App\Form\PaymentType;
use App\Repository\CarteBancaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PaymentController extends AbstractController
{
    #[Route(path: '/payment', name: 'payment')]
    public function pay(Request $request,EntityManagerInterface $entityManager)
    {   $session=$request->getSession();
        $person=$session->get('id');
        if(!$person)
            return $this->redirectToRoute('login_page');
        $paymentform = $this->createForm(PaymentType::class);
        $paymentform->handleRequest($request);
        if ($paymentform->isSubmitted() && $paymentform->isValid()) {
            $number=$paymentform->get('numero')->getData();
            $code=$paymentform->get('code')->getData();
            $card=$entityManager->getRepository(CarteBancaire::class)->findOneBy(['numero'=>$number]);
            if(!$card)
            {$this->addFlash('danger', 'Invalid credentials.');}
            else{
                $c=$card->getCode();
                if($c==$code)
                    {$this->addFlash('success', 'Payment successful');
                        return $this->redirectToRoute('home');}
                else{$this->addFlash('danger', 'Invalid credentials.');}
            }
        }
        return $this->render('payment/payment.html.twig', ['form' => $paymentform->createView()]);
    }
}
