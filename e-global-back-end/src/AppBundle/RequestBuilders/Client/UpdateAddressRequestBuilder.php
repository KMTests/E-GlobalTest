<?php

namespace AppBundle\RequestBuilders\Client;

use ApiBundle\RequestProcessing\BaseRequestBuilder;
use AppBundle\RequestBuilders\Client\Traits\IsAdminOrOwner;
use AppBundle\Requests\Client\UpdateAddressRequest;
use AppBundle\Responses\Client\ClientAddressResponse;

/**
 * Class UpdateAddressRequestBuilder
 * @package AppBundle\RequestBuilders\Client
 */
class UpdateAddressRequestBuilder extends BaseRequestBuilder {

    use IsAdminOrOwner;

    /**
     * @var string|UpdateAddressRequest
     */
    public $request = UpdateAddressRequest::class;
    public $path = '/clients/{client_id}/addresses/{address_id}';
    public $methods = [BaseRequestBuilder::METHOD_UPDATE];
    public $response = ClientAddressResponse::class;
    public $requirements = [
        'client_id' => '\d+',
        'address_id' => '\d+'
    ];

}