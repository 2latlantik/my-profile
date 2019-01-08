<?php

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

class TagManager
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TagRepository
     */
    private $repository;

    /**
     * TagManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Tag::class);
    }

    public function findWithConditions(array $conditions)
    {
        return $this->repository->findBy($conditions);
    }
}
