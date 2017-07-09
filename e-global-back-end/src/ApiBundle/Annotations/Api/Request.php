<?php

namespace ApiBundle\Annotations\Api;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Request
 * @package ApiBundle\Annotations\Api
 * @Annotation
 * @Target({"METHOD"})
 */
class Request {

    /**
     * @var string
     */
    public $value;

}