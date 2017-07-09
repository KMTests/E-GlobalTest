<?php

namespace AppBundle\Responses\Client;

use ApiBundle\Responses\ApiBaseResponse;
use AppBundle\Entity\Client;
use AppBundle\Entity\ShippingAddress;

/**
 * Class ClientResponse
 * @package AppBundle\Responses\Client
 */
class ClientResponse extends ApiBaseResponse {

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getView() {
        $view = [
            'client_id' => $this->client->getId(),
            'first_name' => $this->client->getFirstName(),
            'last_name' => $this->client->getLastName(),
            'shipping_addresses' => []
        ];
        foreach ($this->client->getShippingAddresses() as $address) {
            $view['shipping_addresses'][] = $this->createAddressView($address);
        }
        return $view;
    }

    protected function createAddressView(ShippingAddress $address) {
        return [
            'id' => $address->getId(),
            'country' => $address->getCountry(),
            'city' => $address->getCity(),
            'street' => $address->getStreet(),
            'zipcode' => $address->getZipcode(),
            'default' => $address->getDefaultAddress(),
        ];
    }
}