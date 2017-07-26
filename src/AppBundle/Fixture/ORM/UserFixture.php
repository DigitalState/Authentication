<?php

namespace AppBundle\Fixture\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\ORM\ResourceFixture;

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
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $this->parse($this->getResource());

        foreach ($users as $user) {
            $entity = $userManager->createUser();
            $entity
                ->setUuid($user['uuid'])
                ->setUsername($user['username'])
                ->setEmail($user['email'])
                ->setPlainPassword($user['password'])
                ->setRoles($user['roles'])
                ->setOwner($user['owner'])
                ->setOwnerUuid($user['owner_uuid'])
                ->setIdentity($user['identity'])
                ->setIdentityUuid($user['identity_uuid'])
                ->setEnabled($user['enabled']);
            $userManager->updateUser($entity);
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
