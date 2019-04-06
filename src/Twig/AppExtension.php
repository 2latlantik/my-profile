<?php

namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('age', [$this, 'formatAge']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('period_start', [$this, 'periodStart']),
        ];
    }

    public function formatAge($birthDate)
    {
        $today = new \DateTime();
        $interval = $today->diff($birthDate);
        return $interval->y;
    }

    public function periodStart($start, $end)
    {
        if (empty($end)) {
            $return = $this->translator->trans('message.start.without_end');
        } else {
            $return  = $this->translator->trans('message.start.with_end');
        }

        return $return;
    }
}
