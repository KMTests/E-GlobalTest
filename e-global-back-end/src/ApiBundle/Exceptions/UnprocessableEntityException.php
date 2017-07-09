<?php

namespace ApiBundle\Exceptions;

use ApiBundle\Responses\ValidatorResponse;

/**
 * Class UnprocessableEntityException
 * @package ApiBundle\Exceptions
 */
class UnprocessableEntityException extends ApiBaseException {

    /**
     * @var string
     */
    public $response = ValidatorResponse::class;

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'unprocessable_entity';

    /**
     * @var array
     */
    public $validationErrors = [];

    public function __construct($messageKey = "", array $messageParameters = [], $code = 422, array $errors = []) {
        $this->validationErrors = $errors;
        parent::__construct($messageKey, $messageParameters, $code);
    }

}