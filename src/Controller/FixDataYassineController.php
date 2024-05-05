<?php
namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class FixDataYassineController extends AbstractController
{
    #[Route('/fix/data/yassine', name: 'app_fix_data_yassine')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $Produit = $em->getRepository(Produit::class)->findOneBy(['id' =>4 ]);
        $Produit->setImgPath('client/images/cheesecake.jpg');
        $em->persist($Produit);
        $em->flush();

        $em = $doctrine->getManager();
        $Produit = $em->getRepository(Produit::class)->findOneBy(['id' => 6]);
        $Produit->setImgPath('client/images/chawarma.avif');
        $em->persist($Produit);
        $em->flush();

        return $this->render('fix_data_yassine/index.html.twig', [
            'controller_name' => 'FixDataYassineController',
        ]);
    }
}