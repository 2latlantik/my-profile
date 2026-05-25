<?php
namespace App\Entity;

use App\Annotation\Tokenable;
use App\Repository\PasswordTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PasswordToken
 * @package App\Entity
 * @Tokenable(duration_validity="+2 day")
 */
#[ORM\Entity(repositoryClass: PasswordTokenRepository::class)]
class PasswordToken
{
    use Token;

    /**
     * @var int
     *
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var User
     *
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EAGER')]
    private ?User $user = null;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return PasswordToken
     */
    public function setUser(User $user): PasswordToken
    {
        $this->user = $user;
        return $this;
    }
}
