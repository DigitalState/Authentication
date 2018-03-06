<?php

namespace AppBundle\Action\Token;

use AppBundle\Security\Provider\AnonymousProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnonymousAction
 */
class AnonymousAction
{
    /**
     * @var \AppBundle\Security\Provider\AnonymousProvider
     */
    protected $anonymousProvider;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * Constructor
     *
     * @param \AppBundle\Security\Provider\AnonymousProvider $anonymousProvider
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
     * @Method("POST")
     * @Route(path="/tokens/anonymous")
     */
    public function post()
    {
        $user = $this->anonymousProvider->loadUserByUsername('anonymous@anonymous.ds');
        $token = $this->tokenManager->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
