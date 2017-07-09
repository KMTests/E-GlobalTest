<?php

namespace AppBundle\RequestBuilders\Client;

use ApiBundle\RequestProcessing\BaseRequestBuilder;
use AppBundle\Entity\Client;
use AppBundle\Requests\Client\CreateAddressRequest;
use AppBundle\Responses\Client\ClientAddressResponse;

/**
 * Class CreateAddressRequestBuilder
 * @package AppBundle\RequestBuilders\Client
 */
class CreateAddressRequestBuilder extends BaseRequestBuilder {

    public $path = '/clients/{client_id}/addresses';
    public $methods = [BaseRequestBuilder::METHOD_CREATE];
    public $response = ClientAddressResponse::class;
    public $requirements = [
        'client_id' => '\d+'
    ];

    /**
     * @var string|CreateAddressRequest
     */
    public $request = CreateAddressRequest::class;

    /**
     * @param Client $user
     * @return bool
     */
    public function authenticate($user) {
        if($user instanceof Client) {
            if($user->isSuperAdmin()) {
                return true;
            } else {
                return $user === $this->request->client;
            }
        }
        return false;
    }
}