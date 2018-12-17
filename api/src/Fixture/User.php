<?php

namespace App\Fixture;

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
        $metadata = $manager->getClassMetadata(User::class);

        foreach ($metadata->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (IdentityListener::class === $listener['class']) {
                    unset($metadata->entityListeners[$event][$key]);
                }
            }
        }

        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE app_user_id_seq RESTART WITH 1');
                break;
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
                ->setEnabled($object->enabled)
                ->setTenant($object->tenant);
            $userManager->updateUser($user);
        }
    }
}
