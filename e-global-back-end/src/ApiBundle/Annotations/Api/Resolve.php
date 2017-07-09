<?php

namespace ApiBundle\Annotations\Api;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Request
 * @package ApiBundle\Annotations\Api
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Resolve {

    /**
     * @var string
     */
    public $value = null;

    /**
     * @var string
     */
    public $resolver = 'kmapi.request_resolver.entity';

}