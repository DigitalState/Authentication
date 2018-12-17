<?php

namespace App\Security\Provider;

use Ds\Component\Security\Model\Identity;
use FOS\UserBundle\Security\UserProvider;

/**
 * Class IndividualProvider
 */
final class IndividualProvider extends UserProvider
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
