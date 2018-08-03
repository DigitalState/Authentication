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
        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE app_user_oauth_id_seq RESTART WITH 1');
                break;
        }

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
