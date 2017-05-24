<?php

namespace Ds\Bundle\UserBundle\DataFixtures\ORM;

use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 */
class LoadUserData extends ResourceFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $this->parse(__DIR__.'/../../Resources/data/{server}/users.yml');

        foreach ($users as $user) {
            $entity = $userManager->createUser();
            $entity
                ->setUsername($user['username'])
                ->setEmail($user['email'])
                ->setPlainPassword($user['password'])
                ->setRoles($user['roles'])
                ->setIdentity($user['identity'])
                ->setIdentityUuid($user['identityUuid'])
                ->setEnabled($user['enabled']);
            $userManager->updateUser($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
