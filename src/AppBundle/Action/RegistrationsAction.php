<?php

namespace AppBundle\Action;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Ds\Component\Config\Service\ConfigService;
use Exception;
use FOS\UserBundle\Model\UserManagerInterface;
use GuzzleHttp;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use stdClass;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationsAction
 */
class RegistrationsAction
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
     * @Method("POST")
     * @Route(path="/registrations")
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

        $username = $request->get('username');
        $password = $request->get('password');
        $exists = $this->userManager->findUserByUsername($username);

        if ($exists) {
            throw new ValidationException(new ConstraintViolationList, 'Username is already taken.');
        }

        $individual = $this->createIndividual();
        $user = $this->userManager->createUser();
        $user
            ->setUsername($username)
            ->setEmail($username)
            ->setPlainPassword($password)
            ->setRoles([$this->configService->get('app.registration.individual.roles')])
            ->setOwner($this->configService->get('app.registration.individual.owner'))
            ->setOwnerUuid($this->configService->get('app.registration.individual.owner_uuid'))
            ->setIdentity($this->configService->get('app.registration.individual.identity'))
            ->setIdentityUuid($individual->uuid)
            ->setEnabled($this->configService->get('app.registration.individual.enabled'));

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
        $request = $this->requestStack->getCurrentRequest();
        $handler = $this->userManager->findUserByUsername($this->configService->get('app.registration.handler'));
        $token = $this->tokenManager->create($handler);

        $client = new GuzzleHttp\Client;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ];
        $json = [
            'owner' => $this->configService->get('app.registration.individual.owner'),
            'ownerUuid' => $this->configService->get('app.registration.individual.owner_uuid'),
            'version' => 1
        ];

        try {
            $personaData = GuzzleHttp\json_decode($request->get('data', '{}'), true);
            $response = $client->request('POST', $this->configService->get('app.registration.endpoint').'/individuals', [
                'headers' => $headers,
                'json' => $json
            ]);
            $individual = GuzzleHttp\json_decode($response->getBody()->getContents());
        } catch (Exception $exception) {
            throw new ValidationException(new ConstraintViolationList, 'Individual could not be created.');
        }

        $json = [
            'owner' => $this->configService->get('app.registration.individual.owner'),
            'ownerUuid' => $this->configService->get('app.registration.individual.owner_uuid'),
            'title' => [
                'en' => 'Default',
                'fr' => 'Défaut'
            ],
            'data' => $personaData,
            'individual' => '/individuals/'.$individual->uuid,
            'version' => 1
        ];

        try {
            $response = $client->request('POST', $this->configService->get('app.registration.endpoint').'/individual-personas', [
                'headers' => $headers,
                'json' => $json
            ]);
        } catch (Exception $exception) {
            throw new ValidationException(new ConstraintViolationList, 'Individual could not be created.');
        }

        return $individual;
    }
}
