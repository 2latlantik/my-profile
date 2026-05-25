<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Skill
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    /**
     * @var int
     *
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: SkillGroup::class, inversedBy: 'skills')]
    private ?SkillGroup $skillGroup = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label = null;

    /**
     * @var float
     *
     */
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private ?float $progression = null;

    /**
     * @var boolean
     *
     */
    #[ORM\Column(name: 'not_evaluated', type: 'boolean', options: ['default' => '0'])]
    private bool $notEvaluated = false;

    public function __construct()
    {
        $this->notEvaluated = 0;
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param SkillGroup $skillGroup
     * @return self
     */
    public function setSkillGroup(SkillGroup $skillGroup): self
    {
        $this->skillGroup = $skillGroup;
        return $this;
    }

    /**
     * @return SkillGroup
     */
    public function getSkillGroup(): ?SkillGroup
    {
        return $this->skillGroup;
    }

    /**
     * @return null|string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Skill
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getProgression(): ?float
    {
        return $this->progression;
    }

    /**
     * @param null|float $progression
     * @return Skill
     */
    public function setProgression(?float $progression): self
    {
        $this->progression = $progression;

        return $this;
    }

    /**
     * set notEvaluated
     *
     * @param bool $notEvaluated
     * @return Skill
     */
    public function setNotEvaluated(bool $notEvaluated): Skill
    {
        $this->notEvaluated = $notEvaluated;
        return $this;
    }

    /**
     * Get notEvaluated
     *
     * @return bool
     */
    public function getNotEvaluated(): bool
    {
        return $this->notEvaluated;
    }
}
