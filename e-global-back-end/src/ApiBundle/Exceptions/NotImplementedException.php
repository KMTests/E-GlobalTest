<?php

namespace ApiBundle\Exceptions;

use Throwable;

class NotImplementedException extends ApiBaseException {

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'not_implemented';

    /**
     * NotImplementedException constructor.
     * @param string $messageKey
     * @param array $messageParameters
     */
    public function __construct($messageKey = '', array $messageParameters = []) {
        parent::__construct($messageKey, $messageParameters, 501);
    }
}