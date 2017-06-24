<?php

namespace Ds\Bundle\TokenBundle\Action\Tokens;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use Ds\Component\Identity\Identity;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class IndividualAction
 */
class IndividualAction
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
     * @Route(path="/tokens/individual")
     * @Method("POST")
     */
    public function post()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request->request->has('username')) {
            throw new ValidationException(new ConstraintViolationList, 'Username is required.');
        }

        if (!$request->request->has('password')) {
            throw new ValidationException(new ConstraintViolationList, 'Password is required.');
        }

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new ValidationException(new ConstraintViolationList, 'User does not exist.');
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $valid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        if (!$valid) {
            throw new ValidationException(new ConstraintViolationList, 'Authentication failed.');
        }

        if (Identity::INDIVIDUAL !== $user->getIdentity()) {
            throw new ValidationException(new ConstraintViolationList, 'User is not an individual.');
        }

        $token = $this->tokenManager->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
