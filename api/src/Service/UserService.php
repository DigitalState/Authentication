<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Api\Model\Individual;
use Ds\Component\Api\Model\IndividualPersona;
use Ds\Component\Api\Model\Organization;
use Ds\Component\Api\Model\OrganizationPersona;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Identity\Model\Identity;
use FOS\UserBundle\Model\UserManagerInterface;
use LogicException;

/**
 * Class UserService
 */
final class UserService extends EntityService
{
    /**
     * @var \FOS\UserBundle\Model\UserManagerInterface
     */
    private $customManager; # region accessor

    /**
     * Get custom manager
     *
     * @return \FOS\UserBundle\Model\UserManagerInterface
     */
    public function getCustomManager()
    {
        return $this->customManager;
    }

    # endregion

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    private $api;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param \FOS\UserBundle\Model\UserManagerInterface $customManager
     * @param \Ds\Component\Api\Api\Api $api
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, UserManagerInterface $customManager, Api $api, string $entity = User::class)
    {
        parent::__construct($manager, $entity);
        $this->customManager = $customManager;
        $this->api = $api;
    }

    /**
     * Create identity for a user
     *
     * @param \App\Entity\User $user
     * @return \App\Entity\User
     * @throws \LogicException
     */
    public function createIdentity(User $user)
    {
        if ($user->getIdentityUuid()) {
            throw new LogicException('Identity already exists.');
        }

        switch ($user->getIdentity()) {
            case Identity::INDIVIDUAL:
                $identity = new Individual;
                $identity
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid());
                $identity = $this->api->get('identities.individual')->create($identity);
                $persona = new IndividualPersona;
                $persona
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid())
                    ->setIndividual($identity)
                    ->setTitle([ // @todo remove hard-coded titles
                        'en' => 'Default',
                        'fr' => 'Défaut'
                    ])
                    ->setData($user->getRegistration()->getData());
                $this->api->get('identities.individual_persona')->create($persona);
                break;

            case Identity::ORGANIZATION:
                $identity = new Organization;
                $identity
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid());
                $identity = $this->api->get('identities.organization')->create($identity);

                $persona = new OrganizationPersona;
                $persona
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid())
                    ->setOrganization($identity)
                    ->setTitle([ // @todo remove hard-coded titles
                        'en' => 'Default',
                        'fr' => 'Défaut'
                    ])
                    ->setData($user->getRegistration()->getData());
                $this->api->get('identities.organization_persona')->create($persona);
                break;

            default:
                throw new DomainException('User identity is not supported.');
        }

        $user->setIdentityUuid($identity->getUuid());
        $this->customManager->updateUser($user);

        return $identity;
    }
}
