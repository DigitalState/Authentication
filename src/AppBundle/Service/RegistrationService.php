<?php

namespace AppBundle\Service;

use AppBundle\Entity\Registration;
use Doctrine\ORM\EntityManager;
use Ds\Component\Entity\Service\EntityService;

/**
 * Class RegistrationService
 */
class RegistrationService extends EntityService
{
    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param string $entity
     */
    public function __construct(EntityManager $manager, $entity = Registration::class)
    {
        parent::__construct($manager, $entity);
    }
}
