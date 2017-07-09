<?php

namespace AppBundle\Responses\Client;

use ApiBundle\Responses\ApiBaseResponse;
use AppBundle\Entity\ShippingAddress;

/**
 * Class ClientAddressResponse
 * @package AppBundle\Responses\Client
 */
class ClientAddressResponse extends ApiBaseResponse {

    /**
     * @var ShippingAddress
     */
    private $shippingAddress;

    /**
     * ClientAddressResponse constructor.
     * @param ShippingAddress $shippingAddress
     */
    public function __construct(ShippingAddress $shippingAddress) {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return array
     */
    public function getView() {
        return [
            'id' => $this->shippingAddress->getId(),
            'country' => $this->shippingAddress->getCountry(),
            'city' => $this->shippingAddress->getCity(),
            'street' => $this->shippingAddress->getStreet(),
            'zipcode' => $this->shippingAddress->getZipcode(),
            'default' => $this->shippingAddress->getDefaultAddress(),
            'client' => $this->shippingAddress->getClient()->getId()
        ];
    }
}