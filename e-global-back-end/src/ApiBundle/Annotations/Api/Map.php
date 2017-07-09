<?php

namespace ApiBundle\Annotations\Api;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Request
 * @package ApiBundle\Annotations\Api
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Map {

    /**
     * @var string
     */
    public $value;

}