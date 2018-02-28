<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Registration;
use AppBundle\EventListener\Registration\UserListener;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class RegistrationFixture
 */
abstract class RegistrationFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = $manager->getClassMetadata(Registration::class);

        foreach ($data->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (UserListener::class === $listener['class']) {
                    unset($data->entityListeners[$event][$key]);
                }
            }
        }

        $registrations = $this->parse($this->getResource());

        foreach ($registrations as $registration) {
            $entity = new Registration;
            $entity
                ->setUuid($registration['uuid'])
                ->setOwner($registration['owner'])
                ->setOwnerUuid($registration['owner_uuid'])
                ->setUsername($registration['username'])
                ->setPassword($registration['password'])
                ->setData($registration['data']);
            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
