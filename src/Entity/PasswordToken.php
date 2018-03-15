<?php
namespace App\Entity;

use App\Annotation\Tokenable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PasswordToken
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PasswordTokenRepository")
 * @Tokenable(duration_validity="+2 day")
 */
class PasswordToken
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
     *      fetch="EAGER"
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
     * @return PasswordToken
     */
    public function setUser(User $user): PasswordToken
    {
        $this->user = $user;
        return $this;
    }
}
