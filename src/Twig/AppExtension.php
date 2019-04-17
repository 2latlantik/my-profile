<?php

namespace App\Twig;

use DateTime;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 * @package App\Twig
 */
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

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('age', [$this, 'formatAge']),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('period_start', [$this, 'periodStart']),
            new TwigFunction('current_profile', [ProfileRuntime::class, 'currentProfile'])
        ];
    }

    /**
     * @param DateTime $birthDate
     * @return int
     * @throws \Exception
     */
    public function formatAge(DateTime $birthDate): int
    {
        $today = new DateTime();
        $interval = $today->diff($birthDate);
        return $interval->y;
    }

    /**
     * @param DateTime|null $end
     * @return string
     */
    public function periodStart(?DateTime $end): string
    {
        if (empty($end)) {
            $return = $this->translator->trans('message.start.without_end');
        } else {
            $return  = $this->translator->trans('message.start.with_end');
        }

        return $return;
    }
}
