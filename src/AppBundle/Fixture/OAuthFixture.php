<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\OAuth;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class OAuthFixture
 */
abstract class OAuthFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $oAuth = new OAuth;
            $oAuth
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setUser($manager->getRepository(User::class)->findOneBy(['uuid' => $object->user]))
                ->setType($object->type)
                ->setIdentifier($object->identifier)
                ->setToken($object->token)
                ->setTenant($object->tenant);
            $manager->persist($oAuth);
            $manager->flush();
        }
    }
}
