<?php

namespace Ds\Bundle\AuthenticationBundle\Security\Provider;

use FOS\UserBundle\Security\UserProvider;
use Ds\Component\Identity\Identity;

/**
 * Class IndividualProvider
 */
class IndividualProvider extends UserProvider
{
    /**
     * {@inheritdoc}
     */
    protected function findUser($username)
    {
        return $this->userManager->findUserBy([
            'username' => $username,
            'identity' => Identity::INDIVIDUAL
        ]);
    }
}
