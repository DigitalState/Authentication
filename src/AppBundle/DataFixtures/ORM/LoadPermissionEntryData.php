<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ds\Component\Security\Fixture\ORM\PermissionEntryFixture;

/**
 * Class LoadPermissionEntryData
 */
class LoadPermissionEntryData extends PermissionEntryFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResource()
    {
        return __DIR__.'/../../Resources/data/{server}/permission_entries.yml';
    }
}
