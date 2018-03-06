<?php

namespace AppBundle\Fixtures;

use AppBundle\Fixture\UserFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class Users
 */
class Users extends UserFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResource()
    {
        return '/srv/api-platform/src/AppBundle/Resources/fixtures/{env}/user/*/users.yml';
    }
}
