<?php
namespace App\Entity;

use App\Annotation\Tokenable;
use App\Repository\UserRegisterTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserRegisterToken
 * @package App\Entity
 * @Tokenable(duration_validity="+2 day")
 */
#[ORM\Entity(repositoryClass: UserRegisterTokenRepository::class)]
class UserRegisterToken
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
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EAGER', cascade: ['persist'])]
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
     * @return UserRegisterToken
     */
    public function setUser(User $user): UserRegisterToken
    {
        $this->user = $user;
        return $this;
    }
}
