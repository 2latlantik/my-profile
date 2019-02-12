<?php

namespace App\EventListener;

use App\Entity\File;
use App\Service\FileManager;
use Doctrine\ORM\Event\PreFlushEventArgs;

/**
 * Class FileListener
 * @package App\EventListener
 */
class FileListener
{

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * FileListener constructor.
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @param PreFlushEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args): void
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getIdentityMap() as $groupEntity) {
            foreach ($groupEntity as $entity) {
                if ($entity instanceof File && null !== $entity->getFile()) {
                    dump($entity);
                    exit();
                    $this->fileManager->deletePrevFile($entity);

                    $fileName = $this->fileManager->upload($entity);
                    $entity->setName($fileName);
                    $entity->setPath('uploads' . DIRECTORY_SEPARATOR . $fileName);
                }
            }
        }
    }
}
