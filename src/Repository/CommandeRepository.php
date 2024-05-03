<?php

namespace App\Repository;

use App\Entity\Commande;
use App\Entity\OrdProduit;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function fetchOrders(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id as cid', 'c.date_commande as cdate', 'c.lieu as clieu', 'u.nom as lname', 'u.prenom as fname', 'u.num_tel as unum_tel', 'p.name as prod', 'o.quantity as quan')
            ->join(Utilisateur::class, 'u', 'WITH', 'u.id = c.id_client')
            ->join(Ordproduit::class, 'o', 'WITH', 'o.id_commande = c.id')
            ->join(Produit::class, 'p', 'WITH', 'p.id = o.id_produit')
            ->where('c.etat_commande = 0')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Commande[] Returns an array of Commande objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Commande
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
