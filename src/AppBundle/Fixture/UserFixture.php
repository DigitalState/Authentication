<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\User;
use AppBundle\EventListener\User\IdentityListener;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class UserFixture
 */
abstract class UserFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = $manager->getClassMetadata(User::class);

        foreach ($data->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (IdentityListener::class === $listener['class']) {
                    unset($data->entityListeners[$event][$key]);
                }
            }
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $objects = $this->parse($this->getResource());

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
                ->setEnabled($object->enabled);
            $userManager->updateUser($user);
        }
    }
}
