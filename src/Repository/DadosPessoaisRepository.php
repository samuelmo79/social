<?php

namespace App\Repository;

use App\Entity\DadosPessoais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DadosPessoais|null find($id, $lockMode = null, $lockVersion = null)
 * @method DadosPessoais|null findOneBy(array $criteria, array $orderBy = null)
 * @method DadosPessoais[]    findAll()
 * @method DadosPessoais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DadosPessoaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DadosPessoais::class);
    }

    // /**
    //  * @return DadosPessoais[] Returns an array of DadosPessoais objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DadosPessoais
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
