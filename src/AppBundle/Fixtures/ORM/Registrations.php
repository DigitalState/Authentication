<?php

namespace AppBundle\Fixtures\ORM;

use AppBundle\Fixture\ORM\RegistrationFixture;
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
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResource()
    {
        return __DIR__.'/../../Resources/data/{env}/*/registrations.yml';
    }
}
