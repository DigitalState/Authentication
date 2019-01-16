<?php

namespace App\Tenant\Loader;

use App\EventListener\Entity\User\IdentityListener;
use Ds\Component\Database\Util\Objects;
use Ds\Component\Tenant\Entity\Tenant;

/**
 * Trait User
 */
trait User
{
    /**
     * @var \App\Service\UserService
     */
    private $userService;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(Tenant $tenant)
    {
        $events = $this->userService->getManager()->getEventManager()->getListeners();

        foreach ($events as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (is_object($listener) && $listener instanceof IdentityListener) {
                    $listener->setEnabled(false);
                } else if (is_string($listener) && $listener === IdentityListener::class) {
                    $this->userService->getManager()->getEventManager()->removeEventListener(['postPersist'], $listener);
                }
            }
        }

        $data = (array) json_decode(json_encode($tenant->getData()));
        $objects = Objects::parseFile($this->path, $data);
        $manager = $this->userService->getCustomManager();

        foreach ($objects as $object) {
            $user = $manager->createUser();
            $user
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
            $manager->updateUser($user);
        }
    }
}
