<?php

namespace AppBundle\Requests\Client;

use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Validator\Constraints as ApiAssert;
use ApiBundle\Annotations\Api;

/**
 * Class UpdateAddressRequest
 * @package AppBundle\Requests\Client
 */
class UpdateAddressRequest {

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

    /**
     * @Api\Map("country")
     * @Assert\Length(
     *      min = 4,
     *      max = 74,
     *      minMessage = "error.to_short",
     *      maxMessage = "error.to_long"
     * )
     */
    public $country;

    /**
     * @Api\Map("city")
     * @Assert\Length(
     *      min = 1,
     *      max = 85,
     *      minMessage = "error.to_short",
     *      maxMessage = "error.to_long"
     * )
     */
    public $city;

    /**
     * @Api\Map("zipcode")
     * @Assert\Length(
     *      min = 2,
     *      max = 16,
     *      minMessage = "error.to_short",
     *      maxMessage = "error.to_long"
     * )
     */
    public $zipcode;

    /**
     * @Api\Map("street")
     * @Assert\Length(
     *      min = 2,
     *      max = 1024,
     *      minMessage = "error.to_short",
     *      maxMessage = "error.to_long"
     * )
     */
    public $street;

    /**
     * @Api\Map("default")
     * @Assert\Type("boolean")
     */
    public $default;

}