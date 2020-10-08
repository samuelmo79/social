<?php

namespace App\Repository;

use App\Entity\Amizade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Amizade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amizade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amizade[]    findAll()
 * @method Amizade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmizadeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amizade::class);
    }

    // /**
    //  * @return Amizade[] Returns an array of Amizade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Amizade
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
