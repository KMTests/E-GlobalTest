<?php

namespace ApiBundle\Factories;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class AnnotationReaderFactory
 * @package ApiBundle\Factories
 */
class AnnotationReaderFactory {

    /**
     * @return AnnotationReader
     */
    public function create() {
        return new AnnotationReader();
    }

}