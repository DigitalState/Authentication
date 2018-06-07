<?php

namespace AppBundle\Security\Provider;

use Ds\Component\Identity\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

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
        $user = $this->userManager->findUserBy([
            'username' => $username,
            'identity' => Identity::INDIVIDUAL
        ]);

        return $user;
    }
}
