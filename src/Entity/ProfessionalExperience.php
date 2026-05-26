<?php

namespace App\Entity;

use App\Repository\ProfessionnalExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProfessionnalExperience
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: ProfessionnalExperienceRepository::class)]
class ProfessionalExperience
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
    private ?string $title = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $society = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $location = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $richTextDelta = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $richTextHtml = null;

    /**
     * @var date
     *
     */
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $start = null;

    /**
     * @var date
     *
     */
    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $end = null;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'professionnalExperiences')]
    private ?Profile $profile = null;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     * @return ProfessionnalExperience
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSociety(): ?string
    {
        return $this->society;
    }

    /**
     * @param null|string $society
     * @return self
     */
    public function setSociety(?string $society): self
    {
        $this->society = $society;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param null|string $location
     * @return self
     */
    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRichTextDelta(): ?string
    {
        return $this->richTextDelta;
    }

    /**
     * @param null|string $richTextDelta
     * @return Profile
     */
    public function setRichTextDelta(?string $richTextDelta): self
    {
        $this->richTextDelta = $richTextDelta;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRichTextHtml(): ?string
    {
        return $this->richTextHtml;
    }

    /**
     * @param null|string $richTextHtml
     * @return Profile
     */
    public function setRichTextHtml(?string $richTextHtml): self
    {
        $this->richTextHtml = $richTextHtml;

        return $this;
    }

    /**
     * @return null|date
     */
    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @param null|\DateTime $start
     * @return self
     */
    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }


    /**
     * @return null|date
     */
    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @param null|\DateTime $end
     * @return self
     */
    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

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
}
