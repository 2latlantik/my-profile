<?php
namespace App\Service;

use App\Entity\File;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileManager
 * @package App\Service
 */
class FileManager
{

    /*
     * @var string
     */
    private $targetDirectory;

    /**
     * @var string
     */
    private $sourceUrl;

    /**
     * FileManager constructor.
     * @param string $targetDirectory
     */
    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param File $file
     * @return string
     */
    public function upload(File $file) :string
    {
        $uploadedFile = $file->getFile();

        $fileName = md5(uniqid()).'.'.$uploadedFile->guessExtension();

        $uploadedFile->move($this->targetDirectory, $fileName);

        return $fileName;
    }

    /**
     * @param File $file
     */
    public function deletePrevFile(File $file): void
    {
        $fileSystem = new Filesystem();

        if ($fileSystem->exists($file->getPath())) {
            $fileSystem->remove($file->getPath());
        }
    }

    public function checkType($currentType, $allowedTypes): bool
    {
        return in_array($currentType, $allowedTypes);
    }

    public function checkSize($currentSize, $maxSize): bool
    {
        return ($currentSize > $maxSize) ? false : true;
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
