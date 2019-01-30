<?php

namespace App\EventListener\Entity\Registration;

use App\Entity\Registration;
use App\Service\RegistrationService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Container\Attribute\Container;
use Ds\Component\Model\Attribute\Enabled;
use Ds\Component\Model\Type\Enableable;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserListener
 */
final class UserListener implements Enableable
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
     * Create user on registration
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $entity = $event->getEntity();

        if (!$entity instanceof Registration) {
            return;
        }

        $this->container->get(RegistrationService::class)->createUser($entity);
    }
}
