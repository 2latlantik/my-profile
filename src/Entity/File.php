<?php
namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class File
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    /**
     * @var int
     *
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var UploadedFile
     *
     * @Assert\NotBlank
     * @Assert\File(
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"},
     *     maxSize="1074000000"
     * )
     */
    private ?UploadedFile $file = null;

    /**
     * @var string
     *
     * @Assert\Type("string")
     */
    #[ORM\Column(type: 'string')]
    private ?string $name = null;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string')]
    private ?string $path = null;

    #[ORM\ManyToOne(targetEntity: FileGroup::class, inversedBy: 'files')]
    private ?FileGroup $fileGroup = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return File
     */
    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return File
     */
    public function setName(string $name): File
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return File
     */
    public function setPath(string $path): File
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param FileGroup $fileGroup
     * @return File
     */
    public function setFileGroup(FileGroup $fileGroup): self
    {
        $this->fileGroup = $fileGroup;
        return $this;
    }

    /**
     * @return FileGroup
     */
    public function getFileGroup(): FileGroup
    {
        return $this->fileGroup;
    }
}
