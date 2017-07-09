<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("client_shipping_addresses")
 */
class ShippingAddress {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=74, nullable=false)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=85, nullable=false)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    protected $zipcode;

    /**
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    protected $street;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="shippingAddresses")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $defaultAddress = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return ShippingAddress
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return ShippingAddress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return ShippingAddress
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return ShippingAddress
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return ShippingAddress
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set defaultAddress
     *
     * @param boolean $defaultAddress
     *
     * @return ShippingAddress
     */
    public function setDefaultAddress($defaultAddress)
    {
        $this->defaultAddress = $defaultAddress;

        return $this;
    }

    /**
     * Get defaultAddress
     *
     * @return boolean
     */
    public function getDefaultAddress()
    {
        return $this->defaultAddress;
    }
}
