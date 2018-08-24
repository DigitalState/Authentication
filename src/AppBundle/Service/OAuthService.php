<?php

namespace AppBundle\Service;

use AppBundle\Entity\OAuth;
use Doctrine\ORM\EntityManager;
use Ds\Component\Entity\Service\EntityService;

/**
 * Class OAuthService
 */
class OAuthService extends EntityService
{
    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param string $entity
     */
    public function __construct(EntityManager $manager, $entity = OAuth::class)
    {
        parent::__construct($manager, $entity);
    }
}
