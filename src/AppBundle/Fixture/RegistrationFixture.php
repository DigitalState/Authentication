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
        $metadata = $manager->getClassMetadata(Registration::class);

        foreach ($metadata->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (UserListener::class === $listener['class']) {
                    unset($metadata->entityListeners[$event][$key]);
                }
            }
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $registration = new Registration;
            $registration
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setUsername($object->username)
                ->setPassword($object->password)
                ->setData($object->data)
                ->setTenant($object->tenant);
            $manager->persist($registration);
            $manager->flush();
        }
    }
}
