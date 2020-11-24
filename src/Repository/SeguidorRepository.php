<?php

namespace App\Repository;

use App\Entity\Seguidor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Seguidor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seguidor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seguidor[]    findAll()
 * @method Seguidor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeguidorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seguidor::class);
    }

    // /**
    //  * @return Seguidor[] Returns an array of Seguidor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Seguidor
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
