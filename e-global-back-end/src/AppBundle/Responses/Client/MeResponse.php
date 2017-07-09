<?php

namespace AppBundle\Responses\Client;

use ApiBundle\Entity\User;

/**
 * Class MeResponse
 * @package AppBundle\Responses\Client
 */
class MeResponse extends ClientResponse {

    public function __construct(User $client) {
        parent::__construct($client);
    }

    /**
     * @return array
     */
    function getView() {
        return array_merge(parent::getView(), ['is_admin' => $this->client->isSuperAdmin()]);
    }

}