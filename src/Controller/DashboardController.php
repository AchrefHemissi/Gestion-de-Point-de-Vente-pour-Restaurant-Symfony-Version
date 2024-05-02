<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(UtilisateurRepository $userRepository,SessionInterface $session): Response
    {
        // Start a session and set some data
        $session->set('me', 'Dhia9030');
        $users = $userRepository->findAll();


        // Render the 'dashboard.twig' template
        return $this->render('admin/dashboard.html.twig', [
            'me' => $session->get('me'),
            'users' => $users,
        ]);


    }
    #[Route('/toggle-user/{id}', name: 'toggle_user', methods: ['POST'])]
    public function toggleUser($id, UtilisateurRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        // Toggle the user's status
        $user->set_is_Banned($user->get_is_Banned() == 0 ? 1 : 0);

        // Save the changes to the database
        $em->persist($user);
        $em->flush();

        // Return the new status as a response
        return new JsonResponse(['status' => $user->get_is_Banned()]);
    }


    #[Route('/fetch-chart', name: 'fetch_chart')]
    public function fetchChart(): JsonResponse
    {
        $repository = $this->em->getRepository(Produit::class);

        // Fetch all 'Produit' entities
        $produits = $repository->findAll();

        // Extract the 'vendu' field from each 'Produit'
        $data = array_map(function($produit) {
            return $produit->getVendu();
        }, $produits);

        return new JsonResponse($data);
    }

    #[Route('/fetch-orders', name: 'fetch_orders')]
    public function fetchOrders(): JsonResponse
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('c.id as cid', 'c.date_commande as cdate', 'c.lieu as clieu', 'u.nom as lname', 'u.prenom as fname', 'u.num_tel as unum_tel', 'p.name as prod', 'o.quantity as quan')
            ->from('App\Entity\Commande', 'c')
            ->join('App\Entity\Utilisateur', 'u', 'WITH', 'u.id = c.id_client')
            ->join('App\Entity\Ordproduit', 'o', 'WITH', 'o.id_commande = c.id')
            ->join('App\Entity\Produit', 'p', 'WITH', 'p.id = o.id_produit')
            ->where('c.etat_commande = 0')
            ->orderBy('c.id', 'ASC');

        $query = $qb->getQuery();
        $orders = $query->getResult();
        // Group orders by their ID
        $groupedOrders = [];
        foreach ($orders as $order) {
            $groupedOrders[$order['cid']][] = $order;
        }

        return new JsonResponse($groupedOrders);
    }

    #[Route('/update-orders/{id}', name: 'update_orders')]
    public function updateOrders($id): JsonResponse
    {
        // Fetch the 'Commande' entity with the given id
        $commande = $this->em->getRepository('App\Entity\Commande')->find($id);

        if (!$commande) {
            throw $this->createNotFoundException('No commande found for id '.$id);
        }

        // Update 'etat_commande' to 1
        $commande->setEtatCommande(1);

        $this->em->persist($commande);

        $this->em->flush();

        return new JsonResponse(['status' => 'success']);
    }


    #[Route('/count-users', name: 'count_users')]
    public function countUsers(): Response
    {
        $query = $this->em->createQueryBuilder()
            ->select('count(u.id)')
            ->from('App\Entity\Utilisateur', 'u')
            ->where('u.is_admin = 0')
            ->getQuery();

        $total = $query->getSingleScalarResult();

        return new Response($total);
    }
    #[Route('/top-selling', name: 'top_selling')]
    public function topSelling(): JsonResponse
    {
        $repository = $this->em->getRepository(Produit::class);

        // Fetch top 3 'Produit' entities ordered by 'vendu' field
        $produits = $repository->findBy([], ['vendu' => 'DESC'], 3);

        // Extract the 'name' and 'vendu' fields from each 'Produit'
        $data = array_map(function($produit) {
            return [
                'name' => $produit->getName(),
                'vendu' => $produit->getVendu()
            ];
        }, $produits);

        return new JsonResponse($data);
    }
}