<?php

namespace Ds\Bundle\TokenBundle\Action;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class TokensAction
 */
class TokensAction
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    protected $encoderFactory;

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
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     * @param \FOS\UserBundle\Model\UserManagerInterface $userManager
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(RequestStack $requestStack, EncoderFactoryInterface $encoderFactory, UserManagerInterface $userManager, JWTTokenManagerInterface $tokenManager)
    {
        $this->requestStack = $requestStack;
        $this->encoderFactory = $encoderFactory;
        $this->userManager = $userManager;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Token
     *
     * @Route(path="/tokens")
     * @Method("POST")
     */
    public function post()
    {
        $request = $this->requestStack->getCurrentRequest();

//        if ($request->request->has('username') && $request->request->has('password')) {
//            $username = $request->request->get('username');
//            $password = $request->request->get('password');
//            $user = $this->userManager->findUserByUsernameOrEmail($username);
//            $encoder = $this->encoderFactory->getEncoder($user);
//            $valid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
//            var_dump($valid);exit;
//        } else {
            $anonymous = $this->userManager->findUserByUsername('anonymous');
            $token = $this->tokenManager->create($anonymous);
//        }

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
