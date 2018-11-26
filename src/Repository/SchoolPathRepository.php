<?php

namespace App\Repository;

use App\Entity\SchoolPath;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SchoolPath::class);
    }
}
