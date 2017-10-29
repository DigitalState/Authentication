<?php

namespace AppBundle\Fixture\ORM;

use AppBundle\Entity\Registration;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\ORM\ResourceFixture;

/**
 * Class RegistrationFixture
 */
abstract class RegistrationFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $registrations = $this->parse($this->getResource());

        foreach ($registrations as $registration) {
            $entity = new Registration;
            $entity
                ->setUuid($registration['uuid'])
                ->setOwner($registration['owner'])
                ->setOwnerUuid($registration['owner_uuid'])
                ->setUsername($registration['username'])
                ->setPassword($registration['password'])
                ->setData($registration['data']);
            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
