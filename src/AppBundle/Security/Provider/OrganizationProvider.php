<?php

namespace AppBundle\Security\Provider;

use Ds\Component\Identity\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class OrganizationProvider
 */
class OrganizationProvider extends UserProvider
{
    /**
     * {@inheritdoc}
     */
    protected function findUser($username)
    {
        $user = $this->userManager->findUserBy([
            'username' => $username,
            'identity' => Identity::ORGANIZATION
        ]);

        return $user;
    }
}
