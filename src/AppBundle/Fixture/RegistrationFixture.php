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

        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE app_registration_id_seq RESTART WITH 1');
                break;
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
