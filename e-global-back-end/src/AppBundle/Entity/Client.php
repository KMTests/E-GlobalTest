<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiBundle\Entity\User;

/**
 * @ORM\Entity
 */
class Client extends User {

    /**
     * @ORM\Column(type="string", length=155, nullable=false)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=155, nullable=false)
     */
    protected $lastName;

    /**
     * @ORM\OneToMany(targetEntity="ShippingAddress", mappedBy="client")
     */
    protected $shippingAddresses;

    public function __construct() {
        parent::__construct();
        $this->shippingAddresses = new ArrayCollection();
    }


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Client
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Client
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Add shippingAddress
     *
     * @param \AppBundle\Entity\ShippingAddress $shippingAddress
     *
     * @return Client
     */
    public function addShippingAddress(\AppBundle\Entity\ShippingAddress $shippingAddress)
    {
        $this->shippingAddresses[] = $shippingAddress;

        return $this;
    }

    /**
     * Remove shippingAddress
     *
     * @param \AppBundle\Entity\ShippingAddress $shippingAddress
     */
    public function removeShippingAddress(\AppBundle\Entity\ShippingAddress $shippingAddress)
    {
        $this->shippingAddresses->removeElement($shippingAddress);
    }

    /**
     * Get shippingAddresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShippingAddresses()
    {
        return $this->shippingAddresses;
    }

    public function getDefaultShippingAddress() {
        $defaultAddress = null;
        /** @var ShippingAddress $shippingAddress */
        foreach($this->getShippingAddresses() as $shippingAddress) {
            if($shippingAddress->getDefaultAddress()) {
                $defaultAddress = $shippingAddress;
                break;
            }
        }
        return $defaultAddress;
    }
}
