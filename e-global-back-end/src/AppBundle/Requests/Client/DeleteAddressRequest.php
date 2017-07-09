<?php

namespace AppBundle\Requests\Client;

use ApiBundle\Validator\Constraints as ApiAssert;
use ApiBundle\Annotations\Api;
use AppBundle\Entity\ShippingAddress;

/**
 * Class DeleteAddressRequest
 * @package AppBundle\Requests\Client
 */
class DeleteAddressRequest {

    /**
     * @Api\Map("client_id")
     * @Api\Resolve("AppBundle\Entity\Client")
     * @ApiAssert\InstanceOfClass("AppBundle\Entity\Client", message="client.not_found")
     */
    public $client;

    /**
     * @Api\Map("address_id")
     * @Api\Resolve("AppBundle\Entity\ShippingAddress")
     * @ApiAssert\InstanceOfClass("AppBundle\Entity\ShippingAddress", message="shipping_address.not_found")
     */
    public $shippingAddress;

}