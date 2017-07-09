<?php

namespace AppBundle\RequestBuilders\Client;

use ApiBundle\Entity\User;
use ApiBundle\RequestProcessing\BaseRequestBuilder;
use AppBundle\Responses\Client\MeResponse;

/**
 * Class MeRequestBuilder
 * @package AppBundle\RequestBuilders\Client
 */
class MeRequestBuilder extends BaseRequestBuilder {

    public $path = '/me';
    public $response = MeResponse::class;

    public function authenticate($user) {
        return $user instanceof User;
    }

}