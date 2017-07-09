<?php
namespace AppBundle\Factories;

use AppBundle\Entity\ShippingAddress;

class ShippingAddressFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testItReturnsShippingAddress() {
        $factory = new ShippingAddressFactory();
        $this->assertInstanceOf(ShippingAddress::class, $factory->create());
    }

}
