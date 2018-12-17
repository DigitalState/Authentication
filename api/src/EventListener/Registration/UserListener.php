<?php

namespace App\EventListener\Registration;

use App\Entity\Registration;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserListener
 */
final class UserListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \App\Service\RegistrationService
     */
    private $registrationService;

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
     * @param \App\Entity\Registration $registration
     */
    public function postPersist(Registration $registration)
    {
        // Circular reference error workaround
        $this->registrationService = $this->container->get('app.service.registration');
        //

        $this->registrationService->createUser($registration);
    }
}
