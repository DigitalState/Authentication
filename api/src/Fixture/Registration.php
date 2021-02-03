<?php

namespace App\Fixture;

use App\Entity\Registration as RegistrationEntity;
use App\EventListener\Entity\Registration\UserListener;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait Registration
 */
trait Registration
{
    use Yaml;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $eventManager = $manager->getEventManager();

        foreach ($eventManager->getListeners() as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (is_object($listener) && $listener instanceof UserListener) {
                    $listener->setEnabled(false);
                } else if (is_string($listener) && $listener === UserListener::class) {
                    $eventManager->removeEventListener(['postPersist'], $listener);
                }
            }
        }

        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $registration = new RegistrationEntity;
            $registration
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setUsername($object->username)
                ->setPassword($object->password)
                ->setData($object->data)
                ->setTenant($object->tenant);

            if (null !== $object->created_at) {
                $date = new DateTime;
                $date->setTimestamp($object->created_at);
                $registration->setCreatedAt($date);
            }

            $manager->persist($registration);
        }

        $manager->flush();
    }
}
