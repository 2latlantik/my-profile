<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: SkillGroup::class, inversedBy: 'skills')]
    private ?SkillGroup $skillGroup = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label = null;

    // Stocké en DECIMAL (string) mais manipulé en float côté PHP
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private ?string $progression = null;

    #[ORM\Column(name: 'not_evaluated', type: 'boolean', options: ['default' => '0'])]
    private bool $notEvaluated = false;

    public function __construct()
    {
        $this->notEvaluated = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setSkillGroup(?SkillGroup $skillGroup): self
    {
        $this->skillGroup = $skillGroup;
        return $this;
    }

    public function getSkillGroup(): ?SkillGroup
    {
        return $this->skillGroup;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Retourne la progression en float (0.00 → 100.00)
     */
    public function getProgression(): ?float
    {
        return $this->progression !== null ? (float) $this->progression : null;
    }

    /**
     * Accepte un float mais stocke un DECIMAL propre
     */
    public function setProgression(?float $progression): self
    {
        $this->progression = $progression !== null
            ? number_format($progression, 2, '.', '')
            : null;

        return $this;
    }

    public function setNotEvaluated(bool $notEvaluated): self
    {
        $this->notEvaluated = $notEvaluated;
        return $this;
    }

    public function getNotEvaluated(): bool
    {
        return $this->notEvaluated;
    }
}
