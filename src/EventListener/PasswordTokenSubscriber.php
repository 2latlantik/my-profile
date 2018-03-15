<?php
namespace App\EventListener;

use App\Annotation\TokenableManager;
use App\Entity\PasswordToken;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PasswordTokenSubscriber implements EventSubscriber
{
    /**
     * @var TokenableManager
     */
    private $tokenManager;

    /**
     * PasswordTokenSubscriber constructor.
     * @param TokenableManager $tokenManager
     */
    public function __construct(TokenableManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist'
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    private function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof PasswordToken) {
            $this->tokenManager->initializeFields($entity);
        }
    }
}
