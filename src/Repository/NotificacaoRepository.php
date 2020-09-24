<?php

namespace App\Repository;

use App\Entity\Notificacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Notificacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notificacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notificacao[]    findAll()
 * @method Notificacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notificacao::class);
    }

    public function getQueryNotificacao($id)
    {
        return $this->createQueryBuilder('l')
            ->where('l.user = :user')
            ->setParameter('user', $id)
            ->orderBy('l.dataNotificacao', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
