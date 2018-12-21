<?php

namespace App\Fixture;

use App\Entity\Registration as RegistrationEntity;
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
            $registration = new RegistrationEntity;
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
