<?php

namespace ApiBundle\Exceptions;

/**
 * Class NotFoundException
 * @package ApiBundle\Exceptions
 */
class NotFoundException extends ApiBaseException {

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'not_found';

    public function __construct($messageKey = "", array $messageParameters = []) {
        parent::__construct($messageKey, $messageParameters, 404);
    }

}