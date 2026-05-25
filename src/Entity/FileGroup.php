<?php
namespace App\Entity;

use App\Repository\FileGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FileGroup
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: FileGroupRepository::class)]
class FileGroup
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'fileGroup', cascade: ['persist'])]
    private Collection $files;

    /**
     * FileGroup constructor.
     */
    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param File $file
     * @return FileGroup
     */
    public function addFile(File $file): self
    {
        $this->files[] = $file;
        $file->setFileGroup($this);
        return $this;
    }

    /**
     * @param File $file
     */
    public function removeFile(File $file): void
    {
        $this->files->removeElement($file);
    }

    /**
     * @return mixed
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }
}
