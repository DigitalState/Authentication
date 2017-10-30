<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use DomainException;
use Ds\Component\Api\Api\Factory;
use Ds\Component\Api\Model\Individual;
use Ds\Component\Api\Model\IndividualPersona;
use Ds\Component\Api\Model\Organization;
use Ds\Component\Api\Model\OrganizationPersona;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Identity\Identity;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Class UserService
 */
class UserService extends EntityService
{
    /**
     * @var \FOS\UserBundle\Model\UserManagerInterface
     */
    protected $customManager; # region accessor

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
     * @var \Ds\Component\Api\Api\Factory
     */
    protected $factory;

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param \FOS\UserBundle\Model\UserManagerInterface $customManager
     * @param \Ds\Component\Api\Api\Factory $factory
     * @param string $entity
     */
    public function __construct(EntityManager $manager, UserManagerInterface $customManager, Factory $factory, $entity = User::class)
    {
        parent::__construct($manager, $entity);

        $this->customManager = $customManager;
        $this->factory = $factory;
    }

    /**
     * Create identity for a user
     *
     * @param \AppBundle\Entity\User $user
     * @return \AppBundle\Entity\User
     */
    public function createIdentity(User $user)
    {
        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        switch ($user->getIdentity()) {
            case Identity::INDIVIDUAL:
                $identity = new Individual;
                $identity
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid());
                $identity = $this->api->identities->individual->create($identity);

                $persona = new IndividualPersona;
                $persona
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid())
                    ->setIdentity($user->getRegistration()->getIdentity())
                    ->setIdentityUuid($identity->getUuid())
                    ->setIndividual($identity)
                    ->setTitle([ // @todo remove hard-coded titles
                        'en' => 'Default',
                        'fr' => 'Défaut'
                    ])
                    ->setData($user->getRegistration()->getData());
                $this->api->identities->individualPersona->create($persona);
                break;

            case Identity::ORGANIZATION:
                $identity = new Organization;
                $identity
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid());
                $identity = $this->api->identities->organization->create($identity);

                $persona = new OrganizationPersona;
                $persona
                    ->setOwner($user->getOwner())
                    ->setOwnerUuid($user->getOwnerUuid())
                    ->setIdentity($user->getRegistration()->getIdentity())
                    ->setIdentityUuid($identity->getUuid())
                    ->setOrganization($identity)
                    ->setTitle([ // @todo remove hard-coded titles
                        'en' => 'Default',
                        'fr' => 'Défaut'
                    ])
                    ->setData($user->getRegistration()->getData());
                $this->api->identities->organizationPersona->create($persona);
                break;

            default:
                throw new DomainException('User identity is not supported.');
        }

        $user->setIdentityUuid($identity->getUuid());
        $this->customManager->updateUser($user);

        return $identity;
    }
}
