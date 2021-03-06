<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ProfileRepository
 * @package App\Repository
 */
class ProfileRepository extends ServiceEntityRepository
{
    /**
     * ProfileRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function findByUser($user): Query
    {
        $query = $this->createQueryBuilder('p')
            ->leftJoin('p.schoolPaths', 'sp')
            ->leftJoin('p.professionnalExperiences', 'pe')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.profilePicture', 'pp')
            ->leftJoin('pp.files', 'ppf')
            ->select('p, sp, pe, t, pp, ppf')
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery();
        return $query;
    }

    public function getRandomEntities($count = 10)
    {
        return  $this->createQueryBuilder('p')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }
}
