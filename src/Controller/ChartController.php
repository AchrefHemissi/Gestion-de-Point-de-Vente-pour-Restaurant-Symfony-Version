<?php
// src/Controller/ChartController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produit;

class ChartController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(SessionInterface $session, EntityManagerInterface $em): JsonResponse
    {
        // Start a session and set some data
        $session->set('user', 'Dhia9030');

        // Render the 'dashboard.twig' template
        return $this->render('dashboard.html.twig', [
            'user' => $session->get('user'),
        ]);
    }

    #[Route('/fetch-chart', name: 'fetch_chart')]
    public function fetchChart(EntityManagerInterface $em): JsonResponse
    {
        $repository = $em->getRepository(Produit::class);

        // Fetch all 'Produit' entities
        $produits = $repository->findAll();

        // Extract the 'vendu' field from each 'Produit'
        $data = array_map(function($produit) {
            return $produit->getVendu();
        }, $produits);

        return new JsonResponse($data);
    }

    #[Route('/fetch-orders', name: 'fetch_orders')]
    public function fetchOrders(EntityManagerInterface $em): JsonResponse
    {
        $qb = $em->createQueryBuilder();

        $qb->select('c.id as cid', 'c.date_commande as cdate', 'c.lieu as clieu', 'u.nom as lname', 'u.prenom as fname', 'u.num_tel as unum_tel', 'p.name as prod', 'o.quantite as quan')
            ->from('App\Entity\Commande', 'c')
            ->join('App\Entity\Utilisateur', 'u', 'WITH', 'u.id = c.id_client')
            ->join('App\Entity\Ordproduit', 'o', 'WITH', 'o.id_commande = c.id')
            ->join('App\Entity\Produit', 'p', 'WITH', 'p.id = o.id_produit')
            ->where('c.etat = 0')
            ->orderBy('c.id', 'ASC');

        $query = $qb->getQuery();
        $orders = $query->getResult();

        return new JsonResponse($orders);
    }
}