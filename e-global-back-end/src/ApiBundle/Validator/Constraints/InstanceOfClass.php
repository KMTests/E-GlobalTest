<?php

namespace ApiBundle\Validator\Constraints;

use ApiBundle\Validator\Validators\InstanceOfClassValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class InstanceOfClass
 * @package ApiBundle\Validator\Constraints
 * @Annotation
 */
class InstanceOfClass extends Constraint {

    /**
     * @var string
     */
    public $value = '';

    /**
     * @var string
     */
    public $message = 'must.be.instance.of_class';

    /**
     * @return string
     */
    public function validatedBy() {
        return InstanceOfClassValidator::class;
    }

}