<?php

namespace AppBundle\EventListener\Registration;

use AppBundle\Entity\Registration;
use Ds\Component\Api\Model\Individual;
use Ds\Component\Api\Model\IndividualPersona;
use Ds\Component\Identity\Identity;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserListener
 */
class UserListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \FOS\UserBundle\Model\UserManagerInterface $userManager
     */
    protected $userManager;

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
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create user on registration
     *
     * @param \AppBundle\Entity\Registration $registration
     */
    public function postPersist(Registration $registration)
    {
        // Circular reference error workaround
        // @todo Look into fixing this
        $this->userManager = $this->container->get('fos_user.user_manager');
        $this->factory = $this->container->get('ds_api.factory');
        $this->configService = $this->container->get('ds_config.service.config');
        //

        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        $individual = new Individual;
        $individual
            ->setOwner($this->configService->get('app.registration.individual.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.owner_uuid'));
        $individual = $this->api->identities->individual->create($individual);

        $persona = new IndividualPersona;
        $persona
            ->setOwner($this->configService->get('app.registration.individual.persona.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.persona.owner_uuid'))
            ->setIdentity(Identity::INDIVIDUAL)
            ->setIdentityUuid($individual->getUuid())
            ->setIndividual($individual)
            ->setTitle([ // @todo remove hard-coded titles
                'en' => 'Default',
                'fr' => 'Défaut'
            ])
            ->setData($registration->getData());
        $persona = $this->api->identities->individualPersona->create($persona);

        $user = $this->userManager->createUser();
        $user
            ->setUsername($registration->getUsername())
            ->setEmail($registration->getUsername())
            ->setPlainPassword($registration->getPassword())
            ->setRoles([$this->configService->get('app.registration.individual.roles')])
            ->setOwner($this->configService->get('app.registration.individual.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.owner_uuid'))
            ->setIdentity(Identity::INDIVIDUAL)
            ->setIdentityUuid($individual->getUuid())
            ->setEnabled($this->configService->get('app.registration.individual.enabled'));

        $this->userManager->updateUser($user);
    }
}
