<?php

namespace AppBundle\Fixtures;

use AppBundle\Fixture\RegistrationFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class Registrations
 */
class Registrations extends RegistrationFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResource()
    {
        return '/srv/api-platform/src/AppBundle/Resources/fixtures/{env}/*/registrations.yml';
    }
}
