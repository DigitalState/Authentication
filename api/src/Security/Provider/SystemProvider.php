<?php

namespace App\Security\Provider;

use Ds\Component\Security\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class SystemProvider
 */
final class SystemProvider extends UserProvider
{
    /**
     * {@inheritdoc}
     */
    protected function findUser($username)
    {
        $user = $this->userManager->findUserBy([
            'username' => $username,
            'identity' => Identity::SYSTEM
        ]);

        return $user;
    }
}
