<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\Table(name: 'profile')]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $surname = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[Gedmo\Slug(fields: ['surname', 'name'])]
    #[ORM\Column(length: 128, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $job = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $richTextDelta = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $richTextHtml = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $viadeo = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $linkedin = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $situationState = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $situationGoal = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $gender = null;

    #[ORM\OneToOne(targetEntity: FileGroup::class, cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?FileGroup $profilePicture = null;

    #[ORM\OneToMany(targetEntity: SchoolPath::class, mappedBy: 'profile', cascade: ['persist'])]
    private Collection $schoolPaths;

    #[ORM\OneToMany(targetEntity: ProfessionalExperience::class, mappedBy: 'profile', cascade: ['persist'])]
    private Collection $professionnalExperiences;

    #[ORM\OneToMany(targetEntity: SkillGroup::class, mappedBy: 'profile', cascade: ['persist'])]
    private Collection $skillGroups;

    #[ORM\ManyToMany(targetEntity: Tag::class, cascade: ['persist'])]
    private Collection $tags;

    #[ORM\OneToOne(targetEntity: Leisure::class, cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Leisure $leisure = null;

    public function __construct()
    {
        $this->schoolPaths = new ArrayCollection();
        $this->professionnalExperiences = new ArrayCollection();
        $this->skillGroups = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getRichTextDelta(): ?string
    {
        return $this->richTextDelta;
    }

    public function setRichTextDelta(?string $richTextDelta): self
    {
        $this->richTextDelta = $richTextDelta;
        return $this;
    }

    public function getRichTextHtml(): ?string
    {
        return $this->richTextHtml;
    }

    public function setRichTextHtml(?string $richTextHtml): self
    {
        $this->richTextHtml = $richTextHtml;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getViadeo(): ?string
    {
        return $this->viadeo;
    }

    public function setViadeo(?string $viadeo): self
    {
        $this->viadeo = $viadeo;
        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    public function getSituationState(): ?string
    {
        return $this->situationState;
    }

    public function setSituationState(?string $situationState): self
    {
        $this->situationState = $situationState;
        return $this;
    }

    public function getSituationGoal(): ?string
    {
        return $this->situationGoal;
    }

    public function setSituationGoal(?string $situationGoal): self
    {
        $this->situationGoal = $situationGoal;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getProfilePicture(): ?FileGroup
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?FileGroup $profilePicture): self
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function addSchoolPath(SchoolPath $schoolPath): self
    {
        $this->schoolPaths[] = $schoolPath;
        $schoolPath->setProfile($this);
        return $this;
    }

    public function removeSchoolPath(SchoolPath $schoolPath): void
    {
        $this->schoolPaths->removeElement($schoolPath);
    }

    public function getSchoolPaths(): Collection
    {
        return $this->schoolPaths;
    }

    public function addProfessionnalExperience(ProfessionalExperience $experience): self
    {
        $this->professionnalExperiences[] = $experience;
        $experience->setProfile($this);
        return $this;
    }

    public function removeProfessionnalExperience(ProfessionalExperience $experience): void
    {
        $this->professionnalExperiences->removeElement($experience);
    }

    public function getProfessionnalExperiences(): Collection
    {
        return $this->professionnalExperiences;
    }

    public function addSkillGroup(SkillGroup $skillGroup): self
    {
        $this->skillGroups[] = $skillGroup;
        $skillGroup->setProfile($this);
        return $this;
    }

    public function removeSkillGroup(SkillGroup $skillGroup): void
    {
        $this->skillGroups->removeElement($skillGroup);
    }

    public function getSkillGroups(): Collection
    {
        return $this->skillGroups;
    }

    public function addTag(Tag $tag): self
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getLeisure(): ?Leisure
    {
        if (!$this->leisure) {
            $this->leisure = new Leisure();
        }
        return $this->leisure;
    }

    public function setLeisure(Leisure $leisure): self
    {
        $this->leisure = $leisure;
        return $this;
    }
}
