<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[UniqueEntity(fields: ['email'])]
#[UniqueEntity(fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $username = null;

    // Non persisté : mot de passe en clair
    #[Assert\NotBlank]
    #[Assert\Length(max: 4096)]
    private ?string $plainPassword = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $registeredAt = null;

    public function __construct(bool $isActive = false, string $registeredAt = 'now')
    {
        $this->isActive = $isActive;
        $this->registeredAt = new \DateTimeImmutable($registeredAt);
    }

    public function __toString(): string
    {
        return $this->email ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /** Modern Symfony serialization */
    public function __serialize(): array
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    public function __unserialize(array $data): void
    {
        [
            $this->id,
            $this->username,
            $this->password
        ] = $data + [null, null, null];
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /** Compatibilité UserInterface */
    public function getUsername(): ?string
    {
        return $this->getUserIdentifier();
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(?\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;
        return $this;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        if (str_contains((string) $this->username, '@')) {
            $context->buildViolation('validators.user.username')
                ->atPath('username')
                ->addViolation();
        }
    }

    public function getSalt(): ?string
    {
        return null;
    }

}
