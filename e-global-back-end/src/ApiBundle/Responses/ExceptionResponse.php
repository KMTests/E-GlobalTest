<?php

namespace ApiBundle\Responses;

use ApiBundle\Exceptions\ApiBaseException;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ExceptionResponse
 * @package ApiBundle\Responses
 */
class ExceptionResponse extends ApiBaseResponse {


    /**
     * @var ApiBaseException
     */
    protected $exception;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * ExceptionResponse constructor.
     * @param ApiBaseException $exception
     * @param TranslatorInterface $translator
     */
    public function __construct(ApiBaseException $exception, TranslatorInterface $translator) {
        $this->exception = $exception;
        $this->translator = $translator;
        $this->statusCode = $exception->getCode();
    }

    /**
     * @return array
     */
    function getView() {
        return [
            'error_code' => $this->exception->getCode(),
            'error_type' => $this->translator->trans($this->exception->errorTypeMessage),
            'error_message' => $this->translator->trans($this->exception->messageKey, $this->exception->messageParameters)
        ];
    }

}