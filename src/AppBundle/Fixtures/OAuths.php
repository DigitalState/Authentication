<?php

namespace AppBundle\Fixtures;

use AppBundle\Fixture\OAuthFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class OAuths
 */
class OAuths extends OAuthFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 21;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResource()
    {
        return '/srv/api-platform/src/AppBundle/Resources/fixtures/{env}/user/*/oauths.yml';
    }
}
