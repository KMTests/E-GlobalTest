<?php

namespace ApiBundle\RequestProcessing;

use ApiBundle\Entity\User;

/**
 * Explanation for routing parameters https://symfony.com/doc/current/components/routing.html
 *
 * Class BaseRequestBuilder
 * @package ApiBundle\RequestProcessing
 */
abstract class BaseRequestBuilder {

    const NO_RESPONSE = 'ApiBundle\Responses\NoResponse';
    const METHOD_GET = 'GET';
    const METHOD_CREATE = 'POST';
    const METHOD_UPDATE = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $defaults = [];

    /**
     * @var array
     */
    public $requirements = [];

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $host = '';

    /**
     * @var array
     */
    public $schemas = ['http', 'https'];

    /**
     * @var array
     */
    public $methods = [BaseRequestBuilder::METHOD_GET];

    /**
     * @var string
     */
    public $condition = '';

    /**
     * @var string
     */
    public $request = '';

    /**
     * @var string
     */
    public $response = BaseRequestBuilder::NO_RESPONSE;

    /**
     * @param mixed $user
     * @return boolean
     */
    abstract public function authenticate($user);

}