<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByAmigos($pesquisarAmigos = null, $id)
    {
        $subquery = $this->createQueryBuilder('sb');
        $subquery->select('sb.id')
            ->join('sb.solicitados','sol')
        ;

        $q = $this->createQueryBuilder("a")
            ->where('a.id <> :id')
            ->andWhere('a.ativo = :ativo')
            ->setParameter('ativo', true)
            ->setParameter('id', $id);

        $q->andWhere(
            $q->expr()->notIn('a.id', $subquery->getDQL())
        );

        if(!empty($pesquisarAmigos)) {
            $q
                ->join('a.dadosPessoais', 'dadosPessoais')
                ->where(
                    $q->expr()->orX(
                        $q->expr()->like('dadosPessoais.nome', ':nome'),
                        $q->expr()->like('dadosPessoais.sobrenome', ':sobrenome')
                    )
                )
                ->andWhere('a.id <> :id')
                ->andWhere('a.ativo = :ativo')
                ->setParameter('id', $id)
                ->setParameter('ativo', true)
                ->setParameter('nome', '%' . $pesquisarAmigos . '%')
                ->setParameter('sobrenome', '%' . $pesquisarAmigos . '%');
        }

        $q->orderBy("a.dataCadastro", 'DESC');

        $query = $q->getQuery();
        dump($query->getSQL());
        return $query->getResult();
    }
}
