<?php

namespace AppBundle\Requests\Client;

use AppBundle\Entity\Client;
use Symfony\Component\Validator\Constraints as Assert;
use ApiBundle\Validator\Constraints as ApiAssert;
use ApiBundle\Annotations\Api;

/**
 * Class CreateAddressRequestBuilder
 * @package AppBundle\Requests\Client
 */
class CreateAddressRequest {

    /**
     * @Api\Map("client_id")
     * @Api\Resolve("AppBundle\Entity\Client")
     * @ApiAssert\InstanceOfClass("AppBundle\Entity\Client", message="client.not_found")
     */
    public $client;

    /**
     * @Api\Map("country")
     * @Assert\NotBlank(message="error.generic.not_blank")
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
     * @Assert\NotBlank(message="error.generic.not_blank")
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
     * @Assert\NotBlank(message="error.generic.not_blank")
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
     * @Assert\NotBlank(message="error.generic.not_blank")
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
    public $default = false;

}