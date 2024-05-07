<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\ProductType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function index(Request $request,ManagerRegistry $doctrine,EntityManagerInterface $manager): Response
    {
        $session=$request->getSession();
        $repository=$doctrine->getRepository(Utilisateur::class);
        $person=$repository->findOneBy(['id'=>$session->get('id')]);

        $session=$request->getSession();
        $person=$session->get('id');

        if(!$person) {
            return $this->redirectToRoute('login_page');
        }

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $secondForm = $this->createForm(ProductType::class);
        $secondForm->handleRequest($request);
        $products = [];

        if($request->isMethod('Post'))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $repository = $doctrine->getRepository(Produit::class);

                $data = $form->getData();
                $value = $data['search'];
                $products = $repository->search($value);
            }

            else {

                $this->addFlash('danger', "We're sorry, but your form submission is not valid. Please check the fields and try again.");

            }
        }


        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'forme' => $form->createView(),
            'products' => $products,
            'form' => $secondForm->createView(),
            'form1' => $secondForm->createView(),
            'form2' => $secondForm->createView(),
            'form3' => $secondForm->createView(),
            'form4' => $secondForm->createView(),
            'form5' => $secondForm->createView(),
            'form6' => $secondForm->createView(),
            'form7' => $secondForm->createView(),
            'form8' => $secondForm->createView(),
            'form9' => $secondForm->createView()

        ]);
    }

}
