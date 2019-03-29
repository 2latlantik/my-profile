<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ProfileRepository
 * @package App\Repository
 */
class ProfileRepository extends ServiceEntityRepository
{
    /**
     * ProfileRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
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
}
