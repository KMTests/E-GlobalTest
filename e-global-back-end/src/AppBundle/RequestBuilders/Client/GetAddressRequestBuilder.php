<?php

namespace AppBundle\RequestBuilders\Client;

use ApiBundle\RequestProcessing\BaseRequestBuilder;
use AppBundle\RequestBuilders\Client\Traits\IsAdminOrOwner;
use AppBundle\Requests\Client\GetAddressRequest;
use AppBundle\Responses\Client\ClientAddressResponse;

/**
 * Class GetAddressRequestBuilder
 * @package AppBundle\RequestBuilders\Client
 */
class GetAddressRequestBuilder extends BaseRequestBuilder {

    /**
     * @var string|GetAddressRequest
     */
    public $request = GetAddressRequest::class;
    public $path = '/clients/{client_id}/addresses/{address_id}';
    public $response = ClientAddressResponse::class;
    public $requirements = [
        'client_id' => '\d+',
        'address_id' => '\d+'
    ];

    public function authenticate($user) {
        return true;
    }
}