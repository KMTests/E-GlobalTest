<?php

namespace ApiBundle\Validator\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class InstanceOfClassValidator
 * @package ApiBundle\Validator\Validators
 */
class InstanceOfClassValidator extends ConstraintValidator{

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint) {
        $namespace = is_object($value) ? get_class($value) : null;
        if ($namespace !== $constraint->value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ subject_class }}', $namespace)
                ->setParameter('{{ expected_class }}', $constraint->value)
                ->addViolation();
        }
    }
}