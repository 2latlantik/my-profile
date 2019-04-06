<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"surname", "name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $job;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $city;

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
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $viadeo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $situationState;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $situationGoal;


    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $gender;

    /**
     * One profile has one profilePicture
     * @OneToOne(targetEntity="App\Entity\FileGroup", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $profilePicture;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\SchoolPath", mappedBy="profile", cascade={"persist"})
    */
    private $schoolPaths;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfessionalExperience", mappedBy="profile", cascade={"persist"})
     */
    private $professionnalExperiences;

    /**
     *  @ORM\OneToMany(targetEntity="App\Entity\SkillGroup", mappedBy="profile", cascade={"persist"})
     */
    private $skillGroups;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * One profile has one Leisure
     * @OneToOne(targetEntity="App\Entity\Leisure", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $leisure;

    /**
     * Profile constructor.
     */
    public function __construct()
    {
        $this->schoolPaths = new ArrayCollection();
        $this->professionnalExperiences = new ArrayCollection();
        $this->skillGroups = new ArrayCollection();
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
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param null|string $slug
     * @return Profile
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * @param null|string $job
     * @return Profile
     */
    public function setJob(?string $job): self
    {
        $this->job = $job;

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
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param null|string $postalCode
     * @return Profile
     */
    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     * @return Profile
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

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
     * @return null|string
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param null|string $mail
     * @return Profile
     */
    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return Profile
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getViadeo(): ?string
    {
        return $this->viadeo;
    }

    /**
     * @param null|string $viadeo
     * @return Profile
     */
    public function setViadeo(?string $viadeo): self
    {
        $this->viadeo = $viadeo;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    /**
     * @param null|string $linkedin
     * @return Profile
     */
    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSituationState(): ?string
    {
        return $this->situationState;
    }

    /**
     * @param null|string $situationState
     * @return Profile
     */
    public function setSituationState(?string $situationState): self
    {
        $this->situationState = $situationState;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSituationGoal(): ?string
    {
        return $this->situationGoal;
    }

    /**
     * @param null|string $situationGoal
     * @return Profile
     */
    public function setSituationGoal(?string $situationGoal): self
    {
        $this->situationGoal = $situationGoal;

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
    * @param SkillGroup $skillGroup
    * @return Profile
    */
    public function addSkillGroup(SkillGroup $skillGroup): self
    {
        $this->skillGroups[] = $skillGroup;
        $skillGroup->setProfile($this);
        return $this;
    }

    /**
     * @param SkillGroup $skillGroup
     */
    public function removeSkillGroup(SkillGroup $skillGroup): void
    {
        $this->skillGroups->removeElement($skillGroup);
    }

    /**
     * @return mixed
     */
    public function getSkillGroups()
    {
        return $this->skillGroups;
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

    /**
     * @return Leisure
     */
    public function getLeisure() :Leisure
    {
        if (empty($this->leisure)) {
            $this->leisure = new Leisure();
        }
        return $this->leisure;
    }

    /**
     * @param Leisure $leisure
     * @return Profile
     */
    public function setLeisure(Leisure $leisure): self
    {
        $this->leisure = $leisure;

        return $this;
    }
}
