<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Class Profile
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
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
     * One Profile has one User.
     * @OneToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * One profile has one profilePicture
     * @OneToOne(targetEntity="App\Entity\FileGroup", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $profilePicture;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $gender;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\SchoolPath", mappedBy="profile", cascade={"persist"})
    */
    private $schoolPaths;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfessionalExperience", mappedBy="profile", cascade={"persist"})
     */
    private $professionnalExperiences;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * Profile constructor.
     */
    public function __construct()
    {
        $this->schoolPaths = new ArrayCollection();
        $this->professionnalExperiences = new ArrayCollection();
        $this->tags = new ArrayCollection();
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
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Profile
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return Profile
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeInterface|null $birthDate
     * @return Profile
     */
    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     * @return Profile
     */
    public function setGender(string $gender = null): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser() :User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Profile
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return FileGroup
     */
    public function getProfilePicture(): ?FileGroup
    {
        return $this->profilePicture;
    }

    /**
     * @param FileGroup $profilePicture
     * @return Profile
     */
    public function setProfilePicture(FileGroup $profilePicture = null): self
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    /**
     * @param SchoolPath $schoolPath
     * @return Profile
     */
    public function addSchoolPath(SchoolPath $schoolPath): self
    {
        $this->schoolPaths[] = $schoolPath;
        $schoolPath->setProfile($this);
        return $this;
    }

    /**
     * @param SchoolPath $schoolPAth
     */
    public function removeSchoolPath(SchoolPath $schoolPath): void
    {
        $this->schoolPaths->removeElement($schoolPath);
    }

    /**
     * @return mixed
     */
    public function getSchoolPaths()
    {
        return $this->schoolPaths;
    }

    /**
     * @param ProfessionalExperience $professionnalExperience
     * @return Profile
     */
    public function addProfessionnalExperience(ProfessionalExperience $professionnalExperience): self
    {
        $this->professionnalExperiences[] = $professionnalExperience;
        $professionnalExperience->setProfile($this);
        return $this;
    }

    /**
     * @param ProfessionalExperience $professionnalExperience
     */
    public function removeProfessionnalExperience(ProfessionalExperience $professionnalExperience): void
    {
        $this->professionnalExperiences->removeElement($professionnalExperience);
    }

    /**
     * @return mixed
     */
    public function getProfessionnalExperiences()
    {
        return $this->professionnalExperiences;
    }

    /**
     * @param Tag $tag
     * @return self
     */
    public function addTag(Tag $tag): self
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }
}
