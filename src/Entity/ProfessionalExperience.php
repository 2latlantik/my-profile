<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProfessionnalExperience
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionnalExperienceRepository")
 */
class ProfessionalExperience
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
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $society;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $richTextDelta;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $richTextHtml;

    /**
     * @var date
     *
     * @ORM\Column(type="date")
     */
    private $start;

    /**
     * @var date
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="professionnalExperiences")
     */
    private $profile;

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
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param null|\DateTime $start
     * @return self
     */
    public function setStart(?\DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }


    /**
     * @return null|date
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param null|\DateTime $end
     * @return self
     */
    public function setEnd(?\DateTime $end): self
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
    public function getProfile(): Profile
    {
        return $this->profile;
    }
}
