<?php

namespace AppBundle\Controller;

use ApiBundle\Controller\ApiController;
use ApiBundle\Annotations\Api;

/**
 * Class ClientController
 * @package AppBundle\Controller
 */
class ClientController extends ApiController {

    /**
     * @Api\Request("AppBundle\RequestBuilders\Client\MeRequestBuilder")
     */
    public function meAction() {
        return $this->view;
    }

    /**
     * @Api\Request("AppBundle\RequestBuilders\Client\GetClientRequestBuilder")
     */
    public function getClientAction() {
        return $this->view;
    }

    /**
     * @Api\Request("AppBundle\RequestBuilders\Client\GetAddressRequestBuilder")
     */
    public function getAddressAction() {
        return $this->view;
    }

    /**
     * @Api\Request("AppBundle\RequestBuilders\Client\CreateAddressRequestBuilder")
     */
    public function createAddressAction() {
        $this->get('e_global.address_manager')->create();
        return $this->view;
    }

    /**
     * @Api\Request("AppBundle\RequestBuilders\Client\UpdateAddressRequestBuilder")
     */
    public function updateAddressAction() {
        $this->get('e_global.address_manager')->update();
        return $this->view;
    }

    /**
     * @Api\Request("AppBundle\RequestBuilders\Client\DeleteAddressRequestBuilder")
     */
    public function removeAddressAction() {
        $this->get('e_global.address_manager')->delete();
        return $this->view;
    }
}