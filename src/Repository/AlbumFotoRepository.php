<?php

namespace App\Repository;

use App\Entity\AlbumFoto;
use App\Enum\PrivacidadeEnum;
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

    public function getQueryFotosPublico($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.user = :id')
            ->andWhere('p.privacidade = :privacidade')
            ->setParameter('id', $id)
            ->setParameter('privacidade', PrivacidadeEnum::PUBLICO)
            ->orderBy('p.dataCriacao', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getQueryFotosAmigos($id)
    {
        $subquery = $this->getEntityManager()->createQueryBuilder();
        $subquery = $subquery->select('u.id')
            ->from('App:User', 'u')
            ->from('App:Amizade', 'a')
            ->andWhere('u.id = a.amigo')
            ->andWhere('u.id = :uid')
            ->setParameter('uid', $id);

        $q = $this->createQueryBuilder('p');

        $q->andWhere('p.privacidade = :amigos');
        $q->andWhere(
            $q->expr()->in('p.user', $subquery->getDQL())
        );
        $q->setParameter('uid',$id);
        $q->setParameter('amigos', PrivacidadeEnum::AMIGOS);

        return $q->getQuery()->getResult();
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
