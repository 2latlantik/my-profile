<?php

namespace App\Service;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ProfileManager
 * @package App\Service
 */
class ProfileManager
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var User
     */
    private $user;

    /**
     * ProfileManager constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $token
     */
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->user = $token->getToken()->getUser();
    }

    /**
     * @return Profile
     */
    public function getProfile(): Profile
    {
        $profile = $this->em->getRepository(Profile::class)->findByUser($this->user)->getResult();
        if (empty($profile)) {
            return $this->createProfile();
        } else {
            return $profile[0];
        }
    }

    /**
     * @param User $user
     * @return Profile|null
     */
    public function getOneProfile(User $user): ?Profile
    {
        $profile = $this->em->getRepository(Profile::class)->findByUser($user)->getResult();

        if (empty($profile)) {
            return null;
        } else {
            return $profile[0];
        }
    }

    /**
     * @return Profile
     */
    private function createProfile() :Profile
    {
        $profile = new Profile();
        $profile->setUser($this->user);

        return $profile;
    }
}
