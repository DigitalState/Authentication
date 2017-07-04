<?php

namespace AppBundle\Security\Provider;

use Ds\Component\Identity\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class AnonymousProvider
 */
class AnonymousProvider extends UserProvider
{
    /**
     * {@inheritdoc}
     */
    protected function findUser($username)
    {
        return $this->userManager->findUserBy([
            'username' => $username,
            'identity' => Identity::ANONYMOUS
        ]);
    }
}
