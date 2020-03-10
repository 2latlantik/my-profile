<?php

namespace App\Repository;

use App\Entity\ProfessionalExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ProfileRepository
 * @package App\Repository
 */
class ProfessionnalExperienceRepository extends ServiceEntityRepository
{
    /**
     * ProfileRepository constructor.
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfessionnalExperience::class);
    }
}
