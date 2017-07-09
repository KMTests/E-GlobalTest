<?php

namespace ApiBundle\EventListeners;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class FosOAuthJsonListener
 * @package ApiBundle\EventListeners
 */
class FosOAuthJsonListener {

    const FOS_OAUTH_TOKEN_PATH = "/oauth/v2/token";

    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        if($request->getContentType() === 'json' && $request->getPathInfo() === self::FOS_OAUTH_TOKEN_PATH) {
            $request->request->add(json_decode($request->getContent(), true));
        }
    }

}