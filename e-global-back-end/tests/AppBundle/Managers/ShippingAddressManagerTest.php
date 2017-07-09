<?php

namespace AppBundle\Managers;

use ApiBundle\ClassBuilder\ExposedContainer;
use ApiBundle\Exceptions\UnprocessableEntityException;
use AppBundle\Entity\Client;
use AppBundle\Entity\ShippingAddress;
use AppBundle\Factories\ShippingAddressFactory;
use AppBundle\Requests\Client\CreateAddressRequest;
use AppBundle\Requests\Client\DeleteAddressRequest;
use AppBundle\Requests\Client\UpdateAddressRequest;
use Doctrine\ORM\EntityManager;

/**
 * Class ShippingAddressManagerTest
 * @package AppBundle\Managers
 */
class ShippingAddressManagerTest extends \PHPUnit_Framework_TestCase {

    public function testItCanBeCreated() {
        $exposedContainer = $this->getMock(ExposedContainer::class);
        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['persist', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();
        $shippingAddressFactory = $this->getMock(ShippingAddressFactory::class);
        $manager = new ShippingAddressManager($exposedContainer, $entityManager, $shippingAddressFactory);
        $this->assertInstanceOf(ShippingAddressManager::class, $manager);
    }

    public function testItCanBuildNewShippingAddress() {
        $exposedContainer = new ExposedContainer();
        $addressFactory = new ShippingAddressFactory();
        $createAddressRequest = new CreateAddressRequest();
        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['persist', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();
        $createAddressRequest->client = new Client();
        $createAddressRequest->default = true;
        $createAddressRequest->city = 'test_city';
        $createAddressRequest->country = 'test_country';
        $createAddressRequest->street = 'test_street';
        $createAddressRequest->zipcode = 'test_zipcode';
        $entityManager->expects($this->once())->method('persist');
        $entityManager->expects($this->once())->method('flush');
        $exposedContainer->expose($createAddressRequest);
        $manager = new ShippingAddressManager($exposedContainer, $entityManager, $addressFactory);
        $manager->create();
        /** @var ShippingAddress $entity */
        $entity = $exposedContainer->get(ShippingAddress::class);
        $this->assertInstanceOf(ShippingAddress::class, $entity);
        $this->assertSame($createAddressRequest->client, $entity->getClient());
        $this->assertSame($createAddressRequest->city, $entity->getCity());
        $this->assertSame($createAddressRequest->country, $entity->getCountry());
        $this->assertSame($createAddressRequest->street, $entity->getStreet());
        $this->assertSame($createAddressRequest->zipcode, $entity->getZipcode());
    }

    public function testItCanUpdateShippingAddress() {
        $exposedContainer = new ExposedContainer();
        $addressFactory = new ShippingAddressFactory();
        $addressRequest = new UpdateAddressRequest();
        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['persist', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();
        $addressRequest->client = new Client();
        $addressRequest->default = true;
        $addressRequest->city = 'test_city';
        $addressRequest->country = 'test_country';
        $addressRequest->street = 'test_street';
        $addressRequest->zipcode = 'test_zipcode';
        $addressRequest->shippingAddress = new ShippingAddress();
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->once())->method('flush');
        $exposedContainer->expose($addressRequest);
        $manager = new ShippingAddressManager($exposedContainer, $entityManager, $addressFactory);
        $manager->update();
        /** @var ShippingAddress $entity */
        $entity = $addressRequest->shippingAddress;
        $this->assertInstanceOf(ShippingAddress::class, $entity);
        $this->assertSame($addressRequest->client, $entity->getClient());
        $this->assertSame($addressRequest->city, $entity->getCity());
        $this->assertSame($addressRequest->country, $entity->getCountry());
        $this->assertSame($addressRequest->street, $entity->getStreet());
        $this->assertSame($addressRequest->zipcode, $entity->getZipcode());
    }

    public function testItCanDeleteShippingAddress() {
        $exposedContainer = new ExposedContainer();
        $addressFactory = new ShippingAddressFactory();
        $deleteAddressRequest = new DeleteAddressRequest();
        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['remove', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();
        $deleteAddressRequest->client = new Client();
        $deleteAddressRequest->shippingAddress = new ShippingAddress();
        $entityManager->expects($this->once())->method('remove');
        $entityManager->expects($this->once())->method('flush');
        $exposedContainer->expose($deleteAddressRequest);
        $manager = new ShippingAddressManager($exposedContainer, $entityManager, $addressFactory);
        $manager->delete();
    }

    public function testItWontDeleteDefaultShippingAddress() {
        $exposedContainer = new ExposedContainer();
        $addressFactory = new ShippingAddressFactory();
        $deleteAddressRequest = new DeleteAddressRequest();
        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['remove', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();
        $deleteAddressRequest->client = new Client();
        $deleteAddressRequest->shippingAddress = new ShippingAddress();
        $deleteAddressRequest->shippingAddress->setDefaultAddress(true);
        $entityManager->expects($this->never())->method('remove');
        $entityManager->expects($this->never())->method('flush');
        $exposedContainer->expose($deleteAddressRequest);
        $manager = new ShippingAddressManager($exposedContainer, $entityManager, $addressFactory);
        $this->setExpectedException(UnprocessableEntityException::class);
        $manager->delete();
    }

}
