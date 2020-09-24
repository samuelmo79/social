<?php

namespace App\Repository;

use App\Entity\PostComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostComentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostComentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostComentario[]    findAll()
 * @method PostComentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostComentario::class);
    }

    // /**
    //  * @return PostComentario[] Returns an array of PostComentario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostComentario
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
