<?php

namespace Ds\Bundle\AuthenticationBundle\Action\Authentication;

use Ds\Bundle\AuthenticationBundle\Security\Provider\AnonymousProvider;
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
     * @var \Ds\Bundle\AuthenticationBundle\Security\Provider\AnonymousProvider
     */
    protected $anonymousProvider;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * Constructor
     *
     * @param \Ds\Bundle\AuthenticationBundle\Security\Provider\AnonymousProvider $anonymousProvider
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(AnonymousProvider $anonymousProvider, JWTTokenManagerInterface $tokenManager)
    {
        $this->anonymousProvider = $anonymousProvider;
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
        $user = $this->anonymousProvider->loadUserByUsername('anonymous');
        $token = $this->tokenManager->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
