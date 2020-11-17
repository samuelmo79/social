<?php

namespace App\Repository;

use App\Entity\AlbumFoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AlbumFoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumFoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumFoto[]    findAll()
 * @method AlbumFoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumFotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumFoto::class);
    }

    // /**
    //  * @return AlbumFoto[] Returns an array of AlbumFoto objects
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
    public function findOneBySomeField($value): ?AlbumFoto
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
