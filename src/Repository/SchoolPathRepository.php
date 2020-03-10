<?php

namespace App\Repository;

use App\Entity\SchoolPath;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ProfileRepository
 * @package App\Repository
 */
class SchoolPathRepository extends ServiceEntityRepository
{
    /**
     * ProfileRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SchoolPath::class);
    }
}
