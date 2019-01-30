<?php

namespace App\Controller\Token;

use App\Security\Provider\AnonymousProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnonymousController
 */
final class AnonymousController
{
    /**
     * @var \App\Security\Provider\AnonymousProvider
     */
    private $anonymousProvider;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    private $tokenManager;

    /**
     * Constructor
     *
     * @param \App\Security\Provider\AnonymousProvider $anonymousProvider
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
     * @Route(path="/auth/anonymous", methods={"POST"})
     */
    public function post()
    {
        $user = $this->anonymousProvider->loadUserByUsername('anonymous@anonymous.ds');
        $token = $this->tokenManager->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
