<?php

namespace App\Repository;

use App\Entity\ProfessionalExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ProfileRepository
 * @package App\Repository
 */
class ProfessionnalExperienceRepository extends ServiceEntityRepository
{
    /**
     * ProfileRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProfessionnalExperience::class);
    }
}
