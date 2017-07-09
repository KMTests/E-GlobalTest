<?php

namespace AppBundle\RequestBuilders\Client;

use ApiBundle\RequestProcessing\BaseRequestBuilder;
use AppBundle\RequestBuilders\Client\Traits\IsAdminOrOwner;
use AppBundle\Requests\Client\DeleteAddressRequest;

/**
 * Class DeleteAddressRequestBuilder
 * @package AppBundle\RequestBuilders\Client
 */
class DeleteAddressRequestBuilder extends BaseRequestBuilder {

    use IsAdminOrOwner;

    /**
     * @var string|DeleteAddressRequest
     */
    public $request = DeleteAddressRequest::class;
    public $path = '/clients/{client_id}/addresses/{address_id}';
    public $methods = [BaseRequestBuilder::METHOD_DELETE];
    public $requirements = [
        'client_id' => '\d+',
        'address_id' => '\d+'
    ];


}