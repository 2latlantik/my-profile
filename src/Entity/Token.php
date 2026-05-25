<?php
namespace App\Entity;

use App\Annotation\TokenableField;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait Token
 * @package App\Entity
 */
trait Token
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @TokenableField()
     */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    protected ?string $token = null;

    /**
     * @var \DateTime
     *
     */
    #[ORM\Column(name: 'created_at', type: 'datetime')]
    protected ?\DateTimeInterface $createdAt = null;

    /**
     * @var \DateTime
     *
     */
    #[ORM\Column(name: 'expired_at', type: 'datetime')]
    protected ?\DateTimeInterface $expiredAt = null;

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime $expiredAt
     */
    public function setExpiredAt(\DateTimeInterface $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }
}
