<?php

namespace ApiBundle\ClassBuilder;
use ApiBundle\Factories\AnnotationReaderFactory;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class ClassFactory
 * @package ApiBundle\ClassBuilder
 */
class ClassFactory {

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * ClassFactory constructor.
     * @param ExposedContainer $exposedContainer
     * @param AnnotationReaderFactory $annotationReaderFactory
     */
    public function __construct(ExposedContainer $exposedContainer, AnnotationReaderFactory $annotationReaderFactory) {
        $this->annotationReader = $annotationReaderFactory->create();
        $this->exposedContainer = $exposedContainer;
    }

    /**
     * @param $namespace
     * @param bool $expose
     * @param array $exposeAlternativeNames
     * @return null|object
     */
    public function createFromNamespace($namespace, $expose = true, $exposeAlternativeNames = []) {
        $classReflection = new \ReflectionClass($namespace);
        $instance = null;
        $constructor = $classReflection->getConstructor();
        if($constructor) {
            $args = $this->getParameters($constructor, []);
            if(!empty($args)) {
                $instance = $classReflection->newInstanceArgs($args);
            }
        }
        $instance = $instance ? $instance : new $namespace;
        $expose ? $this->exposedContainer->expose($instance, $exposeAlternativeNames) : null;
        return $instance;
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     * @param array $args
     * @return array
     */
    private function getParameters(\ReflectionMethod $reflectionMethod, $args = []) {
        $parameters = $reflectionMethod->getParameters();
        if($parameters) {
            foreach ($parameters as $parameter) {
                $position = $parameter->getPosition();
                if(!array_key_exists($position, $args) && $this->exposedContainer->has($parameter->getClass()->name)) {
                    $args[$parameter->getPosition()] = $this->exposedContainer->get($parameter->getClass()->name);
                }
            }
        }
        return $args;
    }

}