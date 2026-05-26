<?php

namespace App\Entity;

use App\Repository\LeisureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Leisure
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: LeisureRepository::class)]
class Leisure
{
    /**
     * @var int
     *
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $richTextDelta = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $richTextHtml = null;

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
    public function getRichTextDelta(): ?string
    {
        return $this->richTextDelta;
    }

    /**
     * @param null|string $richTextDelta
     * @return Leisure
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
     * @return Leisure
     */
    public function setRichTextHtml(?string $richTextHtml): self
    {
        $this->richTextHtml = $richTextHtml;

        return $this;
    }
}
