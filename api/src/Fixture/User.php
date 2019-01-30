<?php

namespace App\Fixture;

use App\EventListener\Entity\User\IdentityListener;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait User
 */
trait User
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
                if (is_object($listener) && $listener instanceof IdentityListener) {
                    $listener->setEnabled(false);
                } else if (is_string($listener) && $listener === IdentityListener::class) {
                    $eventManager->removeEventListener(['postPersist'], $listener);
                }
            }
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $user = $userManager->createUser();
            $user
                ->setUuid($object->uuid)
                ->setUsername($object->username)
                ->setEmail($object->email)
                ->setPlainPassword($object->password)
                ->setRoles($object->roles)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setIdentity($object->identity)
                ->setIdentityUuid($object->identity_uuid)
                ->setEnabled($object->enabled)
                ->setTenant($object->tenant);
            $userManager->updateUser($user);
        }
    }
}
