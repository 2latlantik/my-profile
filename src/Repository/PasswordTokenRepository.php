<?php
namespace App\Repository;

use App\Entity\PasswordToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

class PasswordTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordToken::class);
    }

    public function findByTokenValue($token)
    {
        try {
            return $this->createQueryBuilder('pt')
                ->select('pt, u')
                ->innerJoin('pt.user', 'u')
                ->where('pt.token = :token')
                ->setParameter('token', $token)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
    }
}
