<?php

namespace Ds\Bundle\UserBundle\Action;

use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Model\UserManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class Registration
 */
class Registration
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
     */
    public function __construct(RequestStack $requestStack, UserManagerInterface $userManager)
    {
        $this->requestStack = $requestStack;
        $this->userManager = $userManager;
    }

    /**
     * Registration
     *
     * @Route(path="/registration")
     * @Method("POST")
     */
    public function __invoke()
    {
        // @todo Look into using fos_user registration form
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->userManager->createUser();
        $user
            ->setUsername($request->get('username'))
            ->setEmail($request->get('username'))
            ->setPlainPassword($request->get('password'))
            ->setRoles([ 'ROLE_INDIVIDUAL'])
            ->setIdentity('Individual')
            ->setIdentityUuid(Uuid::uuid4()->toString()) // @todo this should create an individual to the identities microservice
            ->setEnabled(true);

        $this->userManager->updateUser($user);

        return new JsonResponse([ 'uuid' => $user->getUuid() ], Response::HTTP_CREATED);
    }
}
