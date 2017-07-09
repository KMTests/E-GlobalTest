<?php

namespace ApiBundle\Exceptions;

/**
 * Class InternalServerException
 * @package ApiBundle\Exceptions
 */
class InternalServerException extends ApiBaseException {

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'internal_server_error';

    public function __construct($messageKey = "", array $messageParameters = [])
    {
        parent::__construct($messageKey, $messageParameters, 500);
    }

}