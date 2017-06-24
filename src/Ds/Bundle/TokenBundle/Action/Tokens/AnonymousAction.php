<?php

namespace Ds\Bundle\TokenBundle\Action\Tokens;

use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AnonymousAction
 */
class AnonymousAction
{
    /**
     * @var \FOS\UserBundle\Model\UserManagerInterface
     */
    protected $userManager;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * Constructor
     *
     * @param \FOS\UserBundle\Model\UserManagerInterface $userManager
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(UserManagerInterface $userManager, JWTTokenManagerInterface $tokenManager)
    {
        $this->userManager = $userManager;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Token
     *
     * @Route(path="/tokens/anonymous")
     * @Method("POST")
     */
    public function post()
    {
        $user = $this->userManager->findUserByUsername('anonymous');
        $token = $this->tokenManager->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
