<?php

namespace ApiBundle\Responses;

use ApiBundle\Exceptions\UnprocessableEntityException;

class ValidatorResponse extends ExceptionResponse {

    /**
     * @return array
     */
    function getView() {
        $errors = $this->exception instanceof UnprocessableEntityException ? $this->exception->validationErrors : [];
        return array_merge(parent::getView(), ['errors' => $errors]);
    }
}