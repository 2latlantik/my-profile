<?php
namespace App\Annotation;

use App\Entity\UserRegisterToken;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class TokenableManager
 * @package App\Annotation
 */
class TokenableManager
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;

    /**
     * TokenableReader constructor.
     * @param AnnotationReader $reader
     */
    public function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param $entity
     * @return bool
     * @throws \TypeError
     */
    public function initializeFields($entity) :bool
    {
        try {
            $reflectionEntity = new \ReflectionClass(get_class($entity));
        } catch (\ReflectionException $exception) {
            die('Class doesn\'t exist');
        }
        if (!$this->isTokenable($reflectionEntity)) {
            return false;
        }
        $this->setTokenableField($entity, $reflectionEntity);
        $this->buildToken($entity, $reflectionEntity);
        return true;
    }

    public function getState($tokenObject)
    {
        $traits = class_uses($tokenObject);
        foreach ($traits as $k_trait => $v_trait) {
            $traits[$k_trait] = substr($v_trait, strripos($v_trait, '\\') + 1);
        }
        if (!in_array('Token', $traits)) {
            die('Class invalid');
        }
        if (empty($tokenObject->getExpiredAt()) || $tokenObject->getExpiredAt() > new \DateTime()) {
            return 'valid';
        } else {
            return 'expired';
        }
    }

    /**
     * @param $entity
     * @param $reflection
     */
    private function buildToken($entity, $reflection)
    {
        $parametersTokenableAnnotation = $this->extractTokenableParameters($reflection);
        $createdAt = new \DateTime();
        $entity->setCreatedAt($createdAt);
        $entity->setExpiredAt($createdAt);
        foreach ($parametersTokenableAnnotation as $nameProperty => $valueProperty) {
            if ($nameProperty == 'duration_validity') {
                $expiredAt = (clone $createdAt)->modify($valueProperty);
                $entity->setExpiredAt($expiredAt);
            }
        }
    }

    /**
     * @param \ReflectionClass $reflection
     * @return array
     */
    private function extractTokenableParameters(\ReflectionClass $reflection): array
    {
        $parameters = [];
        $propertiesAnnotation = $this->reader->getClassAnnotation($reflection, Tokenable::class);
        try {
            $reflectionAnnotation = new \ReflectionClass(get_class($propertiesAnnotation));
        } catch (\ReflectionException $exception) {
            die('Class doesn\'t exist');
        }
        foreach ($reflectionAnnotation->getProperties() as $property) {
            $parameters[$property->getName()] = $this->accessor->getValue($propertiesAnnotation, $property->getName());
        }
        return $parameters;
    }

    /**
     * @param $entity
     * @param \ReflectionClass $reflection
     * @throws \TypeError
     */
    private function setTokenableField($entity, \ReflectionClass $reflection): void
    {
        foreach ($this->getTokenableField($reflection) as $property => $annotation) {
            $token = bin2hex(random_bytes(24));
            $this->accessor->setValue($entity, $property, $token);
        }
    }

    /**
     * @param \ReflectionClass $reflection
     * @return bool
     */
    private function isTokenable(\ReflectionClass $reflection) : bool
    {
        return $this->reader->getClassAnnotation($reflection, Tokenable::class) !== null;
    }

    /**
     * @param \ReflectionClass $reflection
     * @return array
     */
    private function getTokenableField(\ReflectionClass $reflection): array
    {
        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, TokenableField::class);
            if (null !== $annotation) {
                $properties[$property->getName()] = $annotation;
            }
        }
        return $properties;
    }
}
