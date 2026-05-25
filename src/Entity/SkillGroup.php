<?php

namespace App\Entity;

use App\Repository\SkillGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SkillGroup
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: SkillGroupRepository::class)]
class SkillGroup
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
    private ?string $label = null;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'skillGroups')]
    private ?Profile $profile = null;

    #[ORM\OneToMany(targetEntity: Skill::class, mappedBy: 'skillGroup', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $skills;

    /**
     * SkillGroup constructor.
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
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
     * @return SkillGroup
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @param Profile $profile
     * @return self
     */
    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return Profile
     */
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    /**
     * @param Skill $skill
     * @return SkillGroup
     */
    public function addSkill(Skill $skill): self
    {
        $this->skills[] = $skill;
        $skill->setSkillGroup($this);
        return $this;
    }

    /**
     * @param Skill $skill
     */
    public function removeSkill(Skill $skill): void
    {
        dump($skill);
        $this->skills->removeElement($skill);
    }

    /**
     * @return mixed
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }
}
