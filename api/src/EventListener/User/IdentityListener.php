<?php

namespace App\EventListener\User;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class IdentityListener
 */
final class IdentityListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \App\Service\UserService
     */
    private $userService;

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
     * Create identity on user creation
     *
     * @param \App\Entity\User $user
     */
    public function postPersist(User $user)
    {
        // Circular reference error workaround
        $this->userService = $this->container->get('app.service.user');
        //

        if ($user->getIdentityUuid()) {
            return;
        }

        $this->userService->createIdentity($user);
    }
}
