<?php

namespace App\Repository;

use App\Entity\EventoParticipante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventoParticipante|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventoParticipante|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventoParticipante[]    findAll()
 * @method EventoParticipante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoParticipanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventoParticipante::class);
    }

    public function queryPesquisaSolicitacao($id, $evento)
    {
        return $this->createQueryBuilder('s')
            ->where('s.participante = :user')
            ->andWhere('s.evento = :evento')
            ->setParameter('user', $id)
            ->setParameter('evento', $evento)
            ->getQuery()
            ->getResult()
            ;
    }

    public function contaParticipante($evento)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.evento)')
            ->where('p.evento = :evento')
            ->setParameter('evento', $evento)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function listaParticipantes($evento)
    {
        return $this->createQueryBuilder('s')
            ->where('s.evento = :evento')
            ->setParameter('evento', $evento)
            ->getQuery()
            ->getResult()
            ;
    }
}
