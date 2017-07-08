<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Fixture\ORM\UserFixture;
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
        return __DIR__.'/../../Resources/data/{server}/users/*.yml';
    }
}
