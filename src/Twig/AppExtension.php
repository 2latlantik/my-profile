<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('age', [$this, 'formatAge'])
        ];
    }

    public function formatAge($birthDate)
    {
        $today = new \DateTime();
        $interval = $today->diff($birthDate);
        return $interval->y;
    }
}
