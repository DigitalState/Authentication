<?php

namespace AppBundle\Controller\OAuth;

use HWI\Bundle\OAuthBundle\Controller\ConnectController as HWIConnectController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ConnectController
 */
class ConnectController extends HWIConnectController
{
    /**
     * {@inheritdoc}
     */
    public function redirectToServiceAction(Request $request, $service)
    {
        try {
            $authorizationUrl = $this->container->get('hwi_oauth.security.oauth_utils')->getAuthorizationUrl($request, $service);
        } catch (\RuntimeException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }

        $tenant = $this->get('ds_tenant.service.tenant')->getContext();
        $authorizationUrl .= urlencode('?tenant='.$tenant);

        // Check for a return path and store it before redirect
        if ($request->hasSession()) {
            // initialize the session for preventing SessionUnavailableException
            $session = $request->getSession();
            $session->start();

            foreach ($this->container->getParameter('hwi_oauth.firewall_names') as $providerKey) {
                $sessionKey = '_security.'.$providerKey.'.target_path';
                $sessionKeyFailure = '_security.'.$providerKey.'.failed_target_path';

                $param = $this->container->getParameter('hwi_oauth.target_path_parameter');
                if (!empty($param) && $targetUrl = $request->get($param)) {
                    $session->set($sessionKey, $targetUrl);
                }

                if ($this->container->getParameter('hwi_oauth.failed_use_referer') && !$session->has($sessionKeyFailure) && ($targetUrl = $request->headers->get('Referer')) && $targetUrl !== $authorizationUrl) {
                    $session->set($sessionKeyFailure, $targetUrl);
                }

                if ($this->container->getParameter('hwi_oauth.use_referer') && !$session->has($sessionKey) && ($targetUrl = $request->headers->get('Referer')) && $targetUrl !== $authorizationUrl) {
                    $session->set($sessionKey, $targetUrl);
                }
            }
        }

        return $this->redirect($authorizationUrl);
    }
}
