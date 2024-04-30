<?php

namespace App\Repository;

use App\Entity\OrdProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrdProduit>
 *
 * @method OrdProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdProduit[]    findAll()
 * @method OrdProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdProduit::class);
    }

    //    /**
    //     * @return OrdProduit[] Returns an array of OrdProduit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OrdProduit
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
