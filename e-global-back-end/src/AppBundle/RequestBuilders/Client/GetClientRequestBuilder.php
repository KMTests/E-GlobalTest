<?php

namespace AppBundle\RequestBuilders\Client;

use ApiBundle\RequestProcessing\BaseRequestBuilder;
use AppBundle\Requests\Client\GetClientRequest;
use AppBundle\Responses\Client\ClientResponse;

/**
 * Class GetClientRequestBuilder
 * @package AppBundle\RequestBuilders\Client
 */
class GetClientRequestBuilder extends BaseRequestBuilder {

    public $request = GetClientRequest::class;
    public $path = '/clients/{client_id}';
    public $response = ClientResponse::class;
    public $requirements = [
        'client_id' => '\d+'
    ];

    /**
     * @param mixed $user
     * @return boolean
     */
    public function authenticate($user) {
        return true;
    }
}