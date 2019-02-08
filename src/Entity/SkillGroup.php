<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SkillGroup
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SkillGroupRepository")
 */
class SkillGroup
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="skillGroups")
     */
    private $profile;

    /**
     *  @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="skillGroup", cascade={"persist"})
     */
    private $skills;

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
    public function getProfile(): Profile
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
        $this->skills->removeElement($skill);
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }
}
