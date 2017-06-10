<?php

namespace Ds\Bundle\UserBundle\Action;

use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ds\Component\Config\Service\ConfigService;
use GuzzleHttp;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use stdClass;
use Exception;

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
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \FOS\UserBundle\Model\UserManagerInterface $userManager
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(RequestStack $requestStack, UserManagerInterface $userManager, JWTTokenManagerInterface $tokenManager, ConfigService $configService)
    {
        $this->requestStack = $requestStack;
        $this->userManager = $userManager;
        $this->tokenManager = $tokenManager;
        $this->configService = $configService;
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

        if (!$request->request->has('username')) {
            throw new ValidationException(new ConstraintViolationList, 'Username is required.');
        }

        if (!$request->request->has('password')) {
            throw new ValidationException(new ConstraintViolationList, 'Password is required.');
        }

        $username = $request->get('username');
        $password = $request->get('password');

        $exists = $this->userManager->findUserByUsernameOrEmail($username);

        if ($exists) {
            throw new ValidationException(new ConstraintViolationList, 'Username is already taken.');
        }

        $individual = $this->createIndividual();
        $user = $this->userManager->createUser();
        $user
            ->setUsername($username)
            ->setEmail($username)
            ->setPlainPassword($password)
            ->setRoles([$this->configService->get('ds_user.registration.individual.role')])
            ->setIdentity($this->configService->get('ds_user.registration.individual.identity'))
            ->setIdentityUuid($individual->uuid)
            ->setEnabled($this->configService->get('ds_user.registration.individual.enabled'));

        $this->userManager->updateUser($user);

        return new JsonResponse(new StdClass, Response::HTTP_CREATED);
    }

    /**
     * Create an individual identity
     *
     * @return array
     */
    protected function createIndividual()
    {
        $identities = $this->userManager->findUserByUsername($this->configService->get('ds_user.registration.user'));
        $token = $this->tokenManager->create($identities);

        $client = new GuzzleHttp\Client;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ];
        $json = [
            'owner' => $this->configService->get('ds_user.registration.individual.owner'),
            'ownerUuid' => $this->configService->get('ds_user.registration.individual.owner_uuid')
        ];

        try {
            $response = $client->request('POST', $this->configService->get('ds_user.services.identities.url').'/individuals', [
                'headers' => $headers,
                'json' => $json
            ]);
            $individual = GuzzleHttp\json_decode($response->getBody()->getContents());
        } catch (Exception $exception) {
            throw new ValidationException(new ConstraintViolationList, 'Individual could not be created.');
        }

        $json = [
            'owner' => $this->configService->get('ds_user.registration.individual.owner'),
            'ownerUuid' => $this->configService->get('ds_user.registration.individual.owner_uuid'),
            'title' => [
                'en' => 'Default',
                'fr' => 'Défaut'
            ],
            'individual' => '/individuals/'.$individual->uuid
        ];

        try {
            $response = $client->request('POST', $this->configService->get('ds_user.services.identities.url').'/app_dev.php/individual-personas', [
                'headers' => $headers,
                'json' => $json
            ]);
        } catch (Exception $exception) {
            throw new ValidationException(new ConstraintViolationList, 'Individual could not be created.');
        }

        return $individual;
    }
}
