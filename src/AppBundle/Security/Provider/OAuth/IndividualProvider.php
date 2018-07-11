<?php

namespace AppBundle\Security\Provider\OAuth;

use AppBundle\Entity\OAuth;
use AppBundle\Entity\User;
use AppBundle\Service\OAuthService;
use Ds\Component\Config\Service\ConfigService;
use Exception;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class IndividualProvider
 */
class IndividualProvider extends FOSUBUserProvider
{
    /**
     * @var \AppBundle\Service\OAuthService
     */
    protected $oAuthService;

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
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(UserManagerInterface $userManager, array $properties, OAuthService $oAuthService, ConfigService $configService)
    {
        parent::__construct($userManager, $properties);
        $this->oAuthService = $oAuthService;
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

            $user = new User;
            $user
                ->setUsername($response->getResourceOwner()->getName().'/'.$response->getUsername())
                ->setEmail($response->getEmail())
                ->setPlainPassword(sha1(uniqid().microtime()))
                ->setRoles([])
                ->setOwner($this->configService->get('app.oauth.individual.owner.type'))
                ->setOwnerUuid($this->configService->get('app.oauth.individual.owner.uuid'))
                ->setIdentity('Individual')
                ->setIdentityUuid('d0daa7e4-07d1-47e6-93f2-0629adaa3b49')
                ->setEnabled($this->configService->get('app.oauth.individual.enabled'));
            $this->userManager->updateUser($user);
            $oAuth = new OAuth;
            $oAuth
                ->setUser($user)
                ->setType($response->getResourceOwner()->getName())
                ->setIdentifier($response->getUsername())
                ->setToken($response->getAccessToken())
                ->setOwner($this->configService->get('app.oauth.individual.owner.type'))
                ->setOwnerUuid($this->configService->get('app.oauth.individual.owner.uuid'));
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
