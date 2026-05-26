<?php
namespace App\Annotation;

use Symfony\Component\PropertyAccess\PropertyAccess;

class TokenableManager
{
    private $accessor;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function initializeFields($entity): bool
    {
        $reflectionEntity = new \ReflectionClass($entity);

        if (!$this->isTokenable($reflectionEntity)) {
            return false;
        }

        $this->setTokenableField($entity, $reflectionEntity);
        $this->buildToken($entity, $reflectionEntity);

        return true;
    }

    public function getState($tokenObject)
    {
        $traits = array_map(
            fn($trait) => substr($trait, strripos($trait, '\\') + 1),
            class_uses($tokenObject)
        );

        if (!in_array('Token', $traits)) {
            die('Class invalid');
        }

        if (empty($tokenObject->getExpiredAt()) || $tokenObject->getExpiredAt() > new \DateTime()) {
            return 'valid';
        }

        return 'expired';
    }

    private function buildToken($entity, \ReflectionClass $reflection)
    {
        $parameters = $this->extractTokenableParameters($reflection);

        $createdAt = new \DateTime();
        $entity->setCreatedAt($createdAt);
        $entity->setExpiredAt($createdAt);

        if (isset($parameters['duration_validity'])) {
            $expiredAt = (clone $createdAt)->modify($parameters['duration_validity']);
            $entity->setExpiredAt($expiredAt);
        }
    }

    private function extractTokenableParameters(\ReflectionClass $reflection): array
    {
        $parameters = [];

        $attributes = $reflection->getAttributes(Tokenable::class);

        if (!$attributes) {
            return [];
        }

        $instance = $attributes[0]->newInstance();

        foreach ((new \ReflectionClass($instance))->getProperties() as $property) {
            $parameters[$property->getName()] = $this->accessor->getValue($instance, $property->getName());
        }

        return $parameters;
    }

    private function setTokenableField($entity, \ReflectionClass $reflection): void
    {
        foreach ($this->getTokenableField($reflection) as $property => $attribute) {
            $token = bin2hex(random_bytes(24));
            $this->accessor->setValue($entity, $property, $token);
        }
    }

    private function isTokenable(\ReflectionClass $reflection): bool
    {
        return !empty($reflection->getAttributes(Tokenable::class));
    }

    private function getTokenableField(\ReflectionClass $reflection): array
    {
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(TokenableField::class);

            if (!empty($attributes)) {
                $properties[$property->getName()] = $attributes[0]->newInstance();
            }
        }

        return $properties;
    }
}
