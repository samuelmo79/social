<?php

namespace App\Repository;

use App\Entity\Solicitacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Solicitacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solicitacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solicitacao[]    findAll()
 * @method Solicitacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solicitacao::class);
    }

    // /**
    //  * @return Solicitacao[] Returns an array of Solicitacao objects
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
    public function findOneBySomeField($value): ?Solicitacao
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
