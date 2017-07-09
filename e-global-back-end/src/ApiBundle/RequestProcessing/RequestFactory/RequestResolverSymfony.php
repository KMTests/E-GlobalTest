<?php

namespace ApiBundle\RequestProcessing\RequestFactory;

use ApiBundle\Exceptions\NotImplementedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestResolverSymfony
 * @package ApiBundle\RequestProcessing\RequestFactory
 */
class RequestResolverSymfony implements RequestResolverInterface {

    /**
     * @var null|Request
     */
    private $request;

    /**
     * @var string
     */
    private $defaultContentType;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * RequestResolverSymfony constructor.
     * @param RequestStack $requestStack
     * @param string $defaultContentType
     */
    public function __construct(RequestStack $requestStack, $defaultContentType) {
        $this->request = $requestStack->getCurrentRequest();
        $this->defaultContentType = $defaultContentType;
    }

    /**
     * @throws NotImplementedException
     */
    public function resolveParameters() {
        $routeParams = $this->request->attributes->all()['_route_params'];
        $this->parameters = array_merge($this->parameters, $this->request->query->all(), $routeParams);
        if(in_array(strtoupper($this->request->getMethod()), ['POST', 'PUT', 'DELETE'])) {
            $contentType = $this->getContentType();
            switch ($contentType) {
                case 'application/json':
                    $content = $this->request->getContent();
                    if($content) {
                        $this->parameters = array_merge($this->parameters, json_decode($content, true));
                    }
                    break;
                default:
                    $this->throwUnsupportedContentType();
            }
        }
    }

    /**
     * @return string
     */
    public function getContentType() {
        return $this->request->headers->get('Content-Type', $this->defaultContentType);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null) {
        return $this->has($key) ? $this->parameters[$key] : $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key) {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @return array
     */
    public function getAll() {
        return $this->parameters;
    }

    /**
     * @throws NotImplementedException
     */
    public function throwUnsupportedContentType() {
        throw new NotImplementedException(
            'exception.request.content-type.not_implemented', [
                'content_type' => $this->getContentType(),
                'default_content_type' => $this->defaultContentType
            ]
        );
    }

}