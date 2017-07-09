<?php

namespace AppBundle\Requests\Client;

use ApiBundle\Validator\Constraints as ApiAssert;
use ApiBundle\Annotations\Api;

/**
 * Class GetClientRequest
 * @package AppBundle\Requests\Client
 */
class GetClientRequest {

    /**
     * @Api\Map("client_id")
     * @Api\Resolve("AppBundle\Entity\Client")
     * @ApiAssert\InstanceOfClass("AppBundle\Entity\Client", message="client.not_found")
     */
    public $client;

}