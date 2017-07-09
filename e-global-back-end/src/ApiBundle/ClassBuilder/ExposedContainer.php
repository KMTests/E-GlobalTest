<?php

namespace ApiBundle\ClassBuilder;

/**
 * Class ExposedContainer
 * @package ApiBundle\ClassBuilder
 */
class ExposedContainer {

    /**
     * @var array
     */
    private $container = [];

    /**
     * @param $object
     * @param array $exposeAlternativeNames
     * @return $this
     */
    public function expose($object, $exposeAlternativeNames = []) {
        $this->container[get_class($object)] = $object;
        foreach($exposeAlternativeNames as $name) {
            $this->container[$name] = $object;
        }
        return $this;
    }

    /**
     * @param $namespace
     * @return bool
     */
    public function has($namespace) {
        return array_key_exists($namespace, $this->container);
    }

    /**
     * @param $namespace
     * @return mixed
     */
    public function get($namespace) {
        return $this->container[$namespace];
    }

}