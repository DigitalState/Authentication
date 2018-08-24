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

        $url = parse_url($authorizationUrl);
        parse_str($url['query'], $url['query']);
        $success = $this->get('ds_config.service.config')->get('app.spa.portal.oauth.success');
        $tenant = $this->get('ds_tenant.service.tenant')->getContext();
        $url['query']['redirect_uri'] = $success.'?tenant='.urlencode($tenant).'&service='.urlencode($service);
        $url['query'] = http_build_query($url['query']);
        $authorizationUrl = (function(array $url) {
            $scheme = isset($url['scheme']) ? $url['scheme'] . '://' : '';
            $host = isset($url['host']) ? $url['host'] : '';
            $port = isset($url['port']) ? ':' . $url['port'] : '';
            $user = isset($url['user']) ? $url['user'] : '';
            $pass = isset($url['pass']) ? ':' . $url['pass']  : '';
            $pass = ($user || $pass) ? "$pass@" : '';
            $path = isset($url['path']) ? $url['path'] : '';
            $query = isset($url['query']) ? '?' . $url['query'] : '';
            $fragment = isset($url['fragment']) ? '#' . $url['fragment'] : '';

            return "$scheme$user$pass$host$port$path$query$fragment";
        })($url);

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
