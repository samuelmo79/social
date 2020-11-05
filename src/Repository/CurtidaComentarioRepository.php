<?php

namespace App\Repository;

use App\Entity\CurtidaComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CurtidaComentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurtidaComentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurtidaComentario[]    findAll()
 * @method CurtidaComentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurtidaComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurtidaComentario::class);
    }

    // /**
    //  * @return CurtidaComentario[] Returns an array of CurtidaComentario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CurtidaComentario
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
