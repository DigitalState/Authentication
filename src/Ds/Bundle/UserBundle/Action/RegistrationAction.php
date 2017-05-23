<?php

namespace Ds\Bundle\UserBundle\Action;

use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class RegistrationAction
 */
class RegistrationAction
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \FOS\UserBundle\Model\UserManagerInterface
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \FOS\UserBundle\Model\UserManagerInterface $userManager
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(RequestStack $requestStack, UserManagerInterface $userManager, JWTTokenManagerInterface $tokenManager)
    {
        $this->requestStack = $requestStack;
        $this->userManager = $userManager;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Registration
     *
     * @Route(path="/registration")
     * @Method("POST")
     */
    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        $username = $request->get('username');
        $password = $request->get('password');

        $exists = $this->userManager->findUserByUsernameOrEmail($username);

        if ($exists) {
            return new JsonResponse([ 'error' => 'Username is already taken.' ], Response::HTTP_BAD_REQUEST);
        }

        // @todo Create Individual identity on the Identities microservice

        $user = $this->userManager->createUser();
        $user
            ->setUsername($username)
            ->setEmail($username)
            ->setPlainPassword($password)
            ->setRoles([ 'ROLE_INDIVIDUAL'])
            ->setIdentity('Individual')
            ->setIdentityUuid('fb848938-add9-4c5e-8922-1a841a73d344')
            ->setEnabled(true);

        $this->userManager->updateUser($user);

        return new JsonResponse([ 'uuid' => $user->getUuid() ], Response::HTTP_CREATED);
    }
}
