<?php

namespace App\Service;

use App\Entity\Registration;
use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Entity\Service\EntityService;

/**
 * Class RegistrationService
 */
final class RegistrationService extends EntityService
{
    /**
     * @var \App\Service\UserService
     */
    private $userService;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    private $configService;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param \App\Service\UserService $userService
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, UserService $userService, ConfigService $configService, string $entity = Registration::class)
    {
        parent::__construct($manager, $entity);
        $this->userService = $userService;
        $this->configService = $configService;
    }

    /**
     * Create user from a registration
     *
     * @param \App\Entity\Registration $registration
     * @return \App\Entity\User
     */
    public function createUser(Registration $registration)
    {
        $key = 'app.registration.'.strtolower($registration->getIdentity());
        $configs = [
            'roles' => $this->configService->get($key.'.roles'),
            'owner.type' => $this->configService->get($key.'.owner.type'),
            'owner.uuid' => $this->configService->get($key.'.owner.uuid'),
            'enabled' => $this->configService->get($key.'.enabled')
        ];

        $manager = $this->userService->getCustomManager();
        $user = $manager->createUser();
        $user
            ->setRegistration($registration)
            ->setUsername($registration->getUsername())
            ->setEmail($registration->getUsername())
            ->setPlainPassword($registration->getPassword())
            ->setRoles($configs['roles'])
            ->setOwner($configs['owner.type'])
            ->setOwnerUuid($configs['owner.uuid'])
            ->setIdentity($registration->getIdentity())
            ->setEnabled($configs['enabled']);
        $manager->updateUser($user);

        $registration->setUser($user);
        $this->manager->persist($registration);
        $this->manager->flush();

        return $user;
    }
}
