<?php

namespace AppBundle\Tenant;

use AppBundle\Entity\User;
use AppBundle\EventListener\User\IdentityListener;
use AppBundle\Service\UserService;
use Ds\Component\Tenant\Loader\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Users
 */
class Users implements Loader
{
    /**
     * @var \AppBundle\Service\UserService
     */
    protected $userService;

    /**
     * Constructor
     *
     * @param \AppBundle\Service\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $data)
    {
        $metadata = $this->userService->getManager()->getClassMetadata(User::class);

        foreach ($metadata->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (IdentityListener::class === $listener['class']) {
                    unset($metadata->entityListeners[$event][$key]);
                }
            }
        }

        $yml = file_get_contents('/srv/api-platform/src/AppBundle/Resources/tenant/users.yml');

        // @todo Figure out how symfony does parameter binding and use the same technique
        $yml = strtr($yml, [
            '%user.system.uuid%' => $data['user']['system']['uuid'],
            '%user.system.password%' => $data['user']['system']['password'],
            '%user.admin.uuid%' => $data['user']['admin']['uuid'],
            '%user.admin.password%' => $data['user']['admin']['password'],
            '%business_unit.administration.uuid%' => $data['business_unit']['administration']['uuid'],
            '%tenant.uuid%' => $data['tenant']['uuid']
        ]);

        $users = Yaml::parse($yml, YAML::PARSE_OBJECT_FOR_MAP);
        $manager = $this->userService->getCustomManager();

        foreach ($users->objects as $object) {
            $object = (object) array_merge((array) $users->prototype, (array) $object);
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
