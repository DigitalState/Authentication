<?php

namespace App\EventListener\Entity\User;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Container\Attribute\Container;
use Ds\Component\Model\Attribute\Enabled;
use Ds\Component\Model\Type\Enableable;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class IdentityListener
 */
final class IdentityListener implements Enableable
{
    use Container;
    use Enabled;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->enabled = true;
    }

    /**
     * Create identity on user creation
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $entity = $event->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        if ($entity->getIdentityUuid()) {
            return;
        }

        $this->container->get(UserService::class)->createIdentity($entity);
    }
}
