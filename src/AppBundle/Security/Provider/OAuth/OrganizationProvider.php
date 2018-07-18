<?php

namespace AppBundle\Security\Provider\OAuth;

use AppBundle\Entity\OAuth;
use AppBundle\Service\OAuthService;
use AppBundle\Service\RegistrationService;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Identity\Model\Identity;
use Exception;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OrganizationProvider
 */
class OrganizationProvider extends FOSUBUserProvider
{
    /**
     * @var \AppBundle\Service\OAuthService
     */
    protected $oAuthService;

    /**
     * @var \AppBundle\Service\RegistrationService
     */
    protected $registrationService;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \FOS\UserBundle\Model\UserManagerInterface $userManager
     * @param array $properties
     * @param \AppBundle\Service\OAuthService $oAuthService
     * @param \AppBundle\Service\RegistrationService $registrationService
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(UserManagerInterface $userManager, array $properties, OAuthService $oAuthService, RegistrationService $registrationService, ConfigService $configService)
    {
        parent::__construct($userManager, $properties);
        $this->oAuthService = $oAuthService;
        $this->registrationService = $registrationService;
        $this->configService = $configService;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $oAuth = $this->oAuthService->getRepository()->findOneBy([
            'type' => $response->getResourceOwner()->getName(),
            'identifier' => $response->getUsername()
        ]);

        if ($oAuth) {
            $oAuth->setToken($response->getAccessToken());
            $user = $oAuth->getUser();
        } else {
            $email = $response->getEmail();

            if (null === $email) {
                throw new AccountNotLinkedException('Email is not defined.');
            }

            $user = $this->userManager->findUserByUsernameOrEmail($response->getEmail());

            if ($user) {
                throw new AccountNotLinkedException('Username is not available.');
            }

            $owner = substr($response->getResourceOwner()->getName(), 13);
            $data = [
                '%email%' => $response->getEmail(),
                '%firstName%' => $response->getFirstName(),
                '%lastName%' => $response->getLastName()
            ];

            switch ($owner) {
                case 'github':
                    break;

                case 'google':
                    break;

                case 'twitter':
                    break;
            }

            $registration = $this->registrationService->createInstance();
            $registration
                ->setOwner($this->configService->get('app.registration.organization.owner.type'))
                ->setOwnerUuid($this->configService->get('app.registration.organization.owner.uuid'))
                ->setIdentity(Identity::ORGANIZATION)
                ->setUsername($email)
                ->setPassword(sha1(uniqid().microtime()))
                ->setData(json_decode(strtr($this->configService->get('app.registration.organization.data.'.$owner), $data), true));
            $manager = $this->registrationService->getManager();
            $manager->persist($registration);
            $manager->flush();
            $user = $registration->getUser();
            $oAuth = new OAuth;
            $oAuth
                ->setUser($user)
                ->setType($response->getResourceOwner()->getName())
                ->setIdentifier($response->getUsername())
                ->setToken($response->getAccessToken())
                ->setOwner($registration->getOwner())
                ->setOwnerUuid($registration->getOwnerUuid());
        }

        $manager = $this->oAuthService->getManager();
        $manager->persist($oAuth);
        $manager->flush();

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        throw new Exception('Not yet implemented.');
    }

    /**
     * {@inheritDoc}
     */
    public function disconnect(UserInterface $user, UserResponseInterface $response)
    {
        throw new Exception('Not yet implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        throw new Exception('Not yet implemented.');
    }
}
