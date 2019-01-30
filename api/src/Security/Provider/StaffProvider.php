<?php

namespace App\Security\Provider;

use Ds\Component\Security\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class StaffProvider
 */
final class StaffProvider extends UserProvider
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
