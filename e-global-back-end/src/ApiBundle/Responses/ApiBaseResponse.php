<?php

namespace ApiBundle\Responses;

/**
 * Class ApiBaseResponse
 * @package ApiBundle\Responses
 */
abstract class ApiBaseResponse {

    /**
     * @var int
     */
    public $statusCode = 200;

    /**
     * @return array
     */
    abstract public function getView();

}