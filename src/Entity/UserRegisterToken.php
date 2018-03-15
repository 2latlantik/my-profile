<?php
namespace App\Entity;

use App\Annotation\Tokenable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserRegisterToken
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UserRegisterTokenRepository")
 * @Tokenable(duration_validity="+2 day")
 */
class UserRegisterToken
{
    use Token;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(
     *      targetEntity="App\Entity\User",
     *      fetch="EAGER",
     *      cascade={"persist"}
     * )
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
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
