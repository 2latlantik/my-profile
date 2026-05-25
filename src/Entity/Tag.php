<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tag
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    /**
     * @var int
     *
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
