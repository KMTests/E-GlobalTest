<?php

namespace ApiBundle\Validator;


use ApiBundle\Annotations\Api\Map;
use ApiBundle\Exceptions\UnprocessableEntityException;
use ApiBundle\Factories\AnnotationReaderFactory;
use ApiBundle\Utils\ArrayUtils;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestValidator
 * @package ApiBundle\Validator
 */
class RequestValidator {

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * RequestValidator constructor.
     * @param ValidatorInterface $validator
     * @param AnnotationReaderFactory $annotationReaderFactory
     */
    public function __construct(ValidatorInterface $validator, AnnotationReaderFactory $annotationReaderFactory) {
        $this->validator = $validator;
        $this->annotationReader = $annotationReaderFactory->create();
    }

    /**
     * @param $request
     * @throws UnprocessableEntityException
     */
    public function validate($request) {
        $validationErrors = $this->validator->validate($request);
        $errorContainer = [];
        /** @var ConstraintViolation $error */
        foreach ($validationErrors as $error) {
            $propertyReflection = new \ReflectionProperty($request, $error->getPropertyPath());
            $map = $this->annotationReader->getPropertyAnnotation($propertyReflection, Map::class);
            if($map instanceof Map) {
                ArrayUtils::addToArrayKey($errorContainer, $map->value, $error->getMessage());
            }
        }
        if(count($validationErrors) > 0) {
            throw new UnprocessableEntityException('request.validation.failed', [], 422, $errorContainer);
        }
    }


}