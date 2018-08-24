<?php

namespace AppBundle\EventListener\Registration;

use AppBundle\Entity\Registration;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserListener
 */
class UserListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \AppBundle\Service\RegistrationService
     */
    protected $registrationService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create user on registration
     *
     * @param \AppBundle\Entity\Registration $registration
     */
    public function postPersist(Registration $registration)
    {
        // Circular reference error workaround
        $this->registrationService = $this->container->get('app.service.registration');
        //

        $this->registrationService->createUser($registration);
    }
}
