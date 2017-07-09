<?php

namespace ApiBundle\EventListeners;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class CorsListener
 * @package ApiBundle\EventListeners
 */
class CorsListener {

    public function onKernelRequest(GetResponseEvent $event) {
        // Don't do anything if it's not the master request.
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        $method  = $request->getRealMethod();
        if ('OPTIONS' === $method) {
            $response = new Response();
            $event->setResponse($response);
        }
        return;
    }

    public function onKernelResponse(FilterResponseEvent $event) {
        // Don't do anything if it's not the master request.
        if (!$event->isMasterRequest()) {
            return;
        }
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', "*");
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'content-type, authorization');
        if('OPTIONS' === $event->getRequest()->getRealMethod()) {
            $response->setStatusCode(200);
            $response->setContent('');
        }
        return;
    }
}