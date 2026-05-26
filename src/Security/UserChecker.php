<?php
namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        // On ignore les utilisateurs incomplets (désérialisés sans ID)
        if (!$user instanceof AppUser || !$user->getId()) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // On ignore les utilisateurs incomplets (désérialisés sans ID)
        if (!$user instanceof AppUser || !$user->getId()) {
            return;
        }

        // Ton contrôle métier : compte désactivé
        if (!$user->getIsActive()) {
            $ex = new DisabledException('security.account.disabled');
            $ex->setUser($user);
            throw $ex;
        }
    }
}
