<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SchoolPath
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SchoolPathRepository")
 */
class SchoolPath
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
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $degree;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="schoolPaths")
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
     * @return SchoolPath
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSchool(): ?string
    {
        return $this->school;
    }

    /**
     * @param null|string $school
     * @return SchoolPath
     */
    public function setSchool(?string $school): self
    {
        $this->school = $school;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDegree(): ?string
    {
        return $this->degree;
    }

    /**
     * @param null|string $degree
     * @return SchoolPath
     */
    public function setDegree(?string $degree): self
    {
        $this->degree = $degree;

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
     * @return SchoolPath
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
     * @return SchoolPath
     */
    public function setEnd(?\DateTime $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @param Profile $profile
     * @return SchoolPath
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
