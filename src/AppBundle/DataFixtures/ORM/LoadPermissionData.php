<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ds\Component\Security\Fixture\ORM\PermissionFixture;

/**
 * Class LoadPermissionData
 */
class LoadPermissionData extends PermissionFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResource()
    {
        return __DIR__.'/../../Resources/data/{server}/permissions.yml';
    }
}
