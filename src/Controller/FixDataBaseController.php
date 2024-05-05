<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FixDataBaseController extends AbstractController
{
    #[Route('/fix/data/base', name: 'app_fix_data_base')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $Produit = $em->getRepository(Produit::class)->findOneBy(['id' => 8]);
        $Produit->setImgPath('client/images/FriedChicken.jpg');
        $em->persist($Produit);
        $em->flush();

        $em = $doctrine->getManager();
        $Produit = $em->getRepository(Produit::class)->findOneBy(['id' => 9]);
        $Produit->setImgPath('client/images/mojito.avif');
        $em->persist($Produit);
        $em->flush();

        $em = $doctrine->getManager();
        $Produit = $em->getRepository(Produit::class)->findOneBy(['id' => 10]);
        $Produit->setImgPath('client/uploaded_img/dessert-2.png');
        $em->persist($Produit);
        $em->flush();

        return $this->render($this->json(['message' => 'Database fixed!']));
    }
}
