<?php

namespace App\Repository;

use App\Entity\Bloqueio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Bloqueio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bloqueio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bloqueio[]    findAll()
 * @method Bloqueio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BloqueioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bloqueio::class);
    }

    // /**
    //  * @return Bloqueio[] Returns an array of Bloqueio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bloqueio
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
