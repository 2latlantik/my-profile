<?php

namespace App\Twig;

use App\Entity\Profile;
use App\Entity\User;
use App\Service\ProfileManager;
use Twig\Extension\RuntimeExtensionInterface;

class ProfileRuntime implements RuntimeExtensionInterface
{

    /**
     * @var ProfileManager $profileManager
     */
    private $profileManager;

    /**
     * ProfileRuntime constructor.
     * @param ProfileManager $profileManager
     */
    public function __construct(ProfileManager $profileManager)
    {
        $this->profileManager = $profileManager;
    }

    /**
     * @param User $user
     * @return Profile|null
     */
    public function currentProfile(User $user): ?Profile
    {
        $profile = $this->profileManager->getOneProfile($user);

        return $profile;
    }
}
