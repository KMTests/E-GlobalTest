<?php

namespace ApiBundle\Exceptions;

/**
 * Class SecurityException
 * @package ApiBundle\Exceptions
 */
class SecurityException extends ApiBaseException {

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'security';

    public function __construct($messageKey = "", array $messageParameters = [], $code = 403) {
        parent::__construct($messageKey, $messageParameters, $code);
    }

}