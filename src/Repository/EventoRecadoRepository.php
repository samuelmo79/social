<?php

namespace App\Repository;

use App\Entity\EventoRecado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventoRecado|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventoRecado|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventoRecado[]    findAll()
 * @method EventoRecado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRecadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventoRecado::class);
    }

    public function getQueryRecados($id)
    {
        return $this->createQueryBuilder('r')
            ->where('r.evento = :evento')
            ->setParameter('evento', $id)
            ->orderBy('r.dataRecado', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
