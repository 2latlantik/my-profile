<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class File
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var UploadedFile
     *
     * @Assert\NotBlank
     * @Assert\File(
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"},
     *     maxSize="1074000000"
     * )
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $path;

    /**
     * @ManyToOne(targetEntity="App\Entity\FileGroup", inversedBy="files")
     */
    private $fileGroup;

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
    public function getName(): string
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
