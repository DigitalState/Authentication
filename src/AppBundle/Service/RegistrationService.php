<?php

namespace AppBundle\Service;

use AppBundle\Entity\Registration;
use Doctrine\ORM\EntityManager;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Identity\Identity;

/**
 * Class RegistrationService
 */
class RegistrationService extends EntityService
{
    /**
     * @var \AppBundle\Service\UserService
     */
    protected $userService;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param \AppBundle\Service\UserService $userService
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param string $entity
     */
    public function __construct(EntityManager $manager, UserService $userService, ConfigService $configService, $entity = Registration::class)
    {
        parent::__construct($manager, $entity);

        $this->userService = $userService;
        $this->configService = $configService;
    }

    /**
     * Create user from a registration
     *
     * @param \AppBundle\Entity\Registration $registration
     * @return \AppBundle\Entity\User
     */
    public function createUser(Registration $registration)
    {
        $user = $this->userService->getCustomManager()->createUser();
        $user
            ->setRegistration($registration)
            ->setUsername($registration->getUsername())
            ->setEmail($registration->getUsername())
            ->setPlainPassword($registration->getPassword())
            ->setRoles([$this->configService->get('app.registration.individual.roles')])
            ->setOwner($this->configService->get('app.registration.individual.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.owner_uuid'))
            ->setIdentity(Identity::INDIVIDUAL)
            ->setEnabled($this->configService->get('app.registration.individual.enabled'));

        $this->userService->getCustomManager()->updateUser($user);
        $registration->setUser($user);
        $this->manager->persist($registration);
        $this->manager->flush();

        return $user;
    }
}
