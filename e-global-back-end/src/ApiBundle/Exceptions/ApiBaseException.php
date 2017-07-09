<?php

namespace ApiBundle\Exceptions;

use ApiBundle\Responses\ExceptionResponse;

/**
 * Class ApiBaseException
 * @package ApiBundle\Exceptions
 */
class ApiBaseException extends \Exception {

    const EXCEPTION_MESSAGE_TYPE_BASE = 'exception.type.';

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'internal_server_error';

    /**
     * @var string
     */
    public $messageKey;

    /**
     * @var array
     */
    public $messageParameters = [];

    /**
     * @var string
     */
    public $response = ExceptionResponse::class;

    /**
     * ApiBaseException constructor.
     * @param string $messageKey
     * @param array $messageParameters
     * @param int $code
     */
    public function __construct($messageKey = "", $messageParameters = [], $code = 500) {
        $this->messageKey = $messageKey;
        $this->messageParameters = $messageParameters;
        parent::__construct($messageKey, $code, null);
    }

}