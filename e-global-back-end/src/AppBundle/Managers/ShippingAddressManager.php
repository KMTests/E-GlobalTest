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
 * Class ShippingAddressManager
 * @package AppBundle\Managers
 */
class ShippingAddressManager {

    const MAX_ADDRESS_COUNT = 3;

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ShippingAddressFactory
     */
    private $addressFactory;

    /**
     * ShippingAddressManager constructor.
     * @param ExposedContainer $exposedContainer
     * @param EntityManager $entityManager
     * @param ShippingAddressFactory $addressFactory
     */
    public function __construct(
        ExposedContainer $exposedContainer,
        EntityManager $entityManager,
        ShippingAddressFactory $addressFactory
    ) {
        $this->exposedContainer = $exposedContainer;
        $this->entityManager = $entityManager;
        $this->addressFactory = $addressFactory;
    }

    public function create() {
        /** @var CreateAddressRequest $request */
        $request = $this->exposedContainer->get(CreateAddressRequest::class);
        $this->ensureMaxLimit($request->client);
        $defaultShippingAddress = $request->client->getDefaultShippingAddress();
        $request->default = $defaultShippingAddress ? $request->default : true;
        $shippingAddress = $this->addressFactory->create()
            ->setClient($request->client)
            ->setDefaultAddress($request->default)
            ->setZipcode($request->zipcode)
            ->setStreet($request->street)
            ->setCountry($request->country)
            ->setCity($request->city);
        $this->entityManager->persist($shippingAddress);
        $this->exposedContainer->expose($shippingAddress);
        $request->default && $defaultShippingAddress ? $defaultShippingAddress->setDefaultAddress(false) : null;
        $this->entityManager->flush();
    }

    public function delete() {
        /** @var DeleteAddressRequest $request */
        $request = $this->exposedContainer->get(DeleteAddressRequest::class);
        if($request->shippingAddress->getDefaultAddress()) {
            throw new UnprocessableEntityException('address.cant_delete_default');
        } else {
            $this->entityManager->remove($request->shippingAddress);
            $this->entityManager->flush();
        }
    }

    public function update() {
        /** @var UpdateAddressRequest $request */
        $request = $this->exposedContainer->get(UpdateAddressRequest::class);
        /** @var ShippingAddress $shippingAddress */
        $shippingAddress = $request->shippingAddress;
        !$request->client ?: $shippingAddress->setClient($request->client);
        !$request->zipcode ?: $shippingAddress->setZipcode($request->zipcode);
        !$request->street ?: $shippingAddress->setStreet($request->street);
        !$request->country ?: $shippingAddress->setCountry($request->country);
        !$request->city ?: $shippingAddress->setCity($request->city);
        if($request->default) {
            $defaultShippingAddress = $request->client->getDefaultShippingAddress();
            if($defaultShippingAddress) {
                $defaultShippingAddress->setDefaultAddress(false);
            }
            $shippingAddress->setDefaultAddress(true);
        }
        $this->entityManager->flush();
    }

    /**
     * @param Client $client
     * @param bool $removeOne
     * @throws UnprocessableEntityException
     */
    private function ensureMaxLimit(Client $client, $removeOne = true) {
        $limit = $removeOne ? self::MAX_ADDRESS_COUNT - 1 : self::MAX_ADDRESS_COUNT;
        if(count($client->getShippingAddresses()) > $limit) {
            throw new UnprocessableEntityException(
                'address.max_limit_reached',
                ['max_limit' => self::MAX_ADDRESS_COUNT]
            );
        }
    }

}