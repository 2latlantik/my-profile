<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class FileGroup
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FileGroupRepository")
 */
class FileGroup
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="fileGroup", cascade={"persist"})
     */
    private $files;

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
    public function getFiles()
    {
        return $this->files;
    }
}
