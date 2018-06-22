<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\FileGroup;
use App\Entity\Profile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
    public function getProfile() :Profile
    {
        $profile = $this->em->getRepository(Profile::class)->findBy(array('user' => $this->user->getId()));
        if (empty($profile)) {
            return $this->createProfile();
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
        /*$fileGroup = new FileGroup();
        $file = new File();
        $fileGroup->addFiles($file);
        $profile->setProfilePicture($fileGroup);*/
        return $profile;
    }
}
