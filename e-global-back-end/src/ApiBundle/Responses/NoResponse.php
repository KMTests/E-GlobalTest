<?php

namespace ApiBundle\Responses;

/**
 * Class NoResponse
 * @package ApiBundle\Responses
 */
class NoResponse extends ApiBaseResponse {

    /**
     * @var int
     */
    public $statusCode = 204;

    /**
     * @return array
     */
    public function getView() {
        return [];
    }

}