<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPostagemAmigosPrivados($id)
    {
        $subquery = $this->getEntityManager()->createQueryBuilder();
        $subquery = $subquery->select('u.id')
            ->from('App:User', 'u')
            ->from('App:Amizade', 'a')
            ->andWhere('u.id = a.amigo')
            ->andWhere('a.usuario = :uid')
            ->setParameter('uid', $id);

        $q = $this->createQueryBuilder('p')
            ->join('App:User','us')
        ;
        $q->andWhere('p.privacidade like :amigos');
        $q->orWhere('p.privacidade like :publico');
        $q->andWhere(
            $q->expr()->in('p.autor', $subquery->getDQL())
        );
        $q->setParameter('uid',$id);
        $q->setParameter('amigos', 'Amigos');
        $q->setParameter('publico', 'Publico');


        return $q->getQuery()->getResult();
    }

    public function findPostagemMinhasPublicasOuPrivadas($id)
    {
        $q = $this->createQueryBuilder('p')
            ->andWhere('p.autor = :uid');
        $q->andWhere('p.privacidade like :amigos');
        $q->orWhere('p.privacidade like :publico');
        $q->orWhere('p.privacidade like :privada');
        $q->setParameter('uid', $id);
        $q->setParameter('amigos', 'Amigos');
        $q->setParameter('publico', 'Publico');
        $q->setParameter('privada', 'Privado');

        return $q->getQuery()->getResult();

    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
