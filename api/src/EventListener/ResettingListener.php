<?php

namespace App\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use stdClass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResettingListener
 */
final class ResettingListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     */
    public function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE => 'onResettingSendEmailInitialize',
            FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED => 'onResettingSendEmailCompleted',
            FOSUserEvents::RESETTING_RESET_INITIALIZE => 'onResettingResetInitialize',
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onResettingResetSuccess'
        ];
    }

    /**
     * Return an empty json response if the user does not exist.
     *
     * @param \FOS\UserBundle\Event\GetResponseNullableUserEvent $event
     */
    public function onResettingSendEmailInitialize(GetResponseNullableUserEvent $event)
    {
        $user = $event->getUser();
        $ttl = $this->container->getParameter('fos_user.resetting.retry_ttl');

        if (null !== $user && !$user->isPasswordRequestNonExpired($ttl)) {
            return;
        }

        $response = new JsonResponse(new stdClass, Response::HTTP_CREATED);
        $event->setResponse($response);
    }

    /**
     * Return an empty json response once email has been sent.
     *
     * @param \FOS\UserBundle\Event\GetResponseUserEvent $event
     */
    public function onResettingSendEmailCompleted(GetResponseUserEvent $event)
    {
        $response = new JsonResponse(new stdClass, Response::HTTP_CREATED);
        $event->setResponse($response);
    }

    /**
     * Convert password input to password confirmation input.
     *
     * @param \FOS\UserBundle\Event\GetResponseUserEvent $event
     */
    public function onResettingResetInitialize(GetResponseUserEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $password = $request->request->get('password');
        $request->request->set('fos_user_resetting_form', [
            'plainPassword' => [
                'first' => $password,
                'second' => $password
            ]
        ]);
    }

    public function onResettingResetSuccess(FormEvent $event)
    {
        $response = new JsonResponse(new stdClass, Response::HTTP_CREATED);
        $event->setResponse($response);
    }
}
