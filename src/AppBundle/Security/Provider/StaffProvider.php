<?php

namespace AppBundle\Security\Provider;

use Ds\Component\Identity\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class StaffProvider
 */
class StaffProvider extends UserProvider
{
    /**
     * {@inheritdoc}
     */
    protected function findUser($username)
    {
        $user = $this->userManager->findUserBy([
            'username' => $username,
            'identity' => Identity::STAFF
        ]);

        return $user;
    }
}
