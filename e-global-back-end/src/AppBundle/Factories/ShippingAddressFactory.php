<?php

namespace AppBundle\Factories;

use AppBundle\Entity\ShippingAddress;

/**
 * Class ShippingAddressFactory
 * @package AppBundle\Factories
 */
class ShippingAddressFactory {

    /**
     * @return ShippingAddress
     */
    public function create() {
        return new ShippingAddress();
    }

}