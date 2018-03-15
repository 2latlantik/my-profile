<?php
namespace App\Repository;

use App\Entity\UserRegisterToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRegisterTokenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserRegisterToken::class);
    }

    public function findByTokenValue($token)
    {
        try {
            return $this->createQueryBuilder('urt')
                ->select('urt, u')
                ->innerJoin('urt.user', 'u')
                ->where('urt.token = :token')
                ->setParameter('token', $token)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
    }
}
