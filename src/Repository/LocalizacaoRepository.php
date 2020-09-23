<?php

namespace App\Repository;

use App\Entity\Localizacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Localizacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localizacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localizacao[]    findAll()
 * @method Localizacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalizacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localizacao::class);
    }

    // /**
    //  * @return Localizacao[] Returns an array of Localizacao objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Localizacao
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
