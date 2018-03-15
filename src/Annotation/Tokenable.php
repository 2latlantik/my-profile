<?php
namespace App\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Tokenable
 * @package App\Annotation
 *
 * @Annotation
 * @Target("CLASS")
 */
class Tokenable
{

    /**
     * @var string
     */
    private $duration_validity;

    public function __construct(array $options)
    {
        $this->duration_validity = $options['duration_validity'];
    }

    public function getDurationValidity()
    {
        return $this->duration_validity;
    }
}
