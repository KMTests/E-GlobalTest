<?php

namespace ApiBundle\RequestProcessing\RequestFactory;

use ApiBundle\Exceptions\NotImplementedException;

/**
 * Interface RequestParameterResolverInterface
 * @package ApiBundle\RequestProcessing\RequestFactory
 */
interface RequestResolverInterface {

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * @return array
     */
    public function getAll();

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @throws NotImplementedException
     */
    public function resolveParameters();

    /**
     * @throws NotImplementedException
     */
    public function throwUnsupportedContentType();

}