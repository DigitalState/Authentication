<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Ds\Component\Api\Api\Factory;
use Ds\Component\Api\Model\Individual;
use Ds\Component\Api\Model\IndividualPersona;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Identity\Identity;
use Ds\Component\Entity\Service\EntityService;
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
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param \FOS\UserBundle\Model\UserManagerInterface $customManager
     * @param \Ds\Component\Api\Api\Factory $factory
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param string $entity
     */
    public function __construct(EntityManager $manager, UserManagerInterface $customManager, Factory $factory, ConfigService $configService, $entity = User::class)
    {
        parent::__construct($manager, $entity);

        $this->customManager = $customManager;
        $this->factory = $factory;
        $this->configService = $configService;
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

        $identity = new Individual;
        $identity
            ->setOwner($this->configService->get('app.registration.individual.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.owner_uuid'));
        $identity = $this->api->identities->individual->create($identity);

        $persona = new IndividualPersona;
        $persona
            ->setOwner($this->configService->get('app.registration.individual.persona.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.persona.owner_uuid'))
            ->setIdentity(Identity::INDIVIDUAL)
            ->setIdentityUuid($identity->getUuid())
            ->setIndividual($identity)
            ->setTitle([ // @todo remove hard-coded titles
                'en' => 'Default',
                'fr' => 'Défaut'
            ])
            ->setData($user->getRegistration()->getData());
        $this->api->identities->individualPersona->create($persona);

        $user->setIdentityUuid($identity->getUuid());
        $this->customManager->updateUser($user);

        return $identity;
    }
}
