<?php

namespace App\Fixture;

use App\Entity\Registration as RegistrationEntity;
use App\EventListener\Entity\Registration\UserListener;
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
        $events = $manager->getEventManager()->getListeners();

        foreach ($events as $event => $listeners) {
            foreach ($listeners as $listener) {
                if (!is_object($listener)) {
                    continue;
                }

                if ($listener instanceof UserListener) {
                    $listener->setEnabled(false);
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
            $manager->persist($registration);
            $manager->flush();
        }
    }
}
