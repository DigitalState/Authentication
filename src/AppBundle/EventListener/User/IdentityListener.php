<?php

namespace AppBundle\EventListener\User;

use AppBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class IdentityListener
 */
class IdentityListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \AppBundle\Service\UserService
     */
    protected $userService;

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
     * @param \AppBundle\Entity\User $user
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
