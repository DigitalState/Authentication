<?php

namespace AppBundle\Security\Provider;

use Ds\Component\Identity\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class SystemProvider
 */
class SystemProvider extends UserProvider
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
