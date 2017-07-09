<?php

namespace ApiBundle\Routing;

use ApiBundle\Annotations\Api\Request;
use ApiBundle\Factories\AnnotationReaderFactory;
use ApiBundle\Factories\RouteFactory;
use ApiBundle\RequestProcessing\BaseRequestBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class ApiRouter
 * @package ApiBundle\Routing
 */
class ApiRouter extends Loader {

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var RouteFactory
     */
    private $routeFactory;

    /**
     * @var string
     */
    private $kernelRoot;

    /**
     * ApiRouter constructor.
     * @param $kernelRoot
     * @param AnnotationReaderFactory $annotationReaderFactory
     * @param RouteFactory $routeFactory
     */
    public function __construct($kernelRoot, AnnotationReaderFactory $annotationReaderFactory, RouteFactory $routeFactory) {
        $this->annotationReader = $annotationReaderFactory->create();
        $this->routeFactory = $routeFactory;
        $this->kernelRoot = $kernelRoot;
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return RouteCollection
     */
    public function load($resource, $type = null) {
        $routes = new RouteCollection();
        $this->createRoutes($resource, $routes);
        return $routes;
    }

    /**
     * @param $resource
     * @param RouteCollection $routeCollection
     */
    private function createRoutes($resource, RouteCollection $routeCollection) {
        $finder = Finder::create()->files()->in($this->getSourceDir($resource))->name('*.php');
        /** @var SplFileInfo $file */
        foreach($finder as $file) {
            $classReflection = $this->getClassReflectionFromFile($resource, $file);
            foreach($classReflection->getMethods() as $method) {
                $request = $this->annotationReader->getMethodAnnotation($method, Request::class);
                if($request instanceof Request) {
                    $ctrl = $this->createSymfonyCtrlRepresentation($classReflection->getName(), $method->getName());
                    $this->createNewRoute($routeCollection, $request, $ctrl);
                }
            }
        }
    }

    /**
     * @param $classNamespace
     * @param $methodName
     * @return string
     */
    private function createSymfonyCtrlRepresentation($classNamespace, $methodName) {
        $namespace = explode('\\', $classNamespace);
        $bundle = $namespace[0];
        $ctrl = strstr($namespace[2], 'Controller', true);
        $action = strstr($methodName, 'Action', true);
        return sprintf('%s:%s:%s', $bundle, $ctrl, $action);
    }

    /**
     * @param RouteCollection $routeCollection
     * @param Request $request
     * @param $ctrl
     */
    private function createNewRoute(RouteCollection $routeCollection, Request $request, $ctrl) {
        /** @var BaseRequestBuilder $requestObject */
        $requestObject = new $request->value();
        $routeCollection->add($request->value, $this->routeFactory->create($requestObject->path)
            ->setDefaults(array_merge($requestObject->defaults, ['_controller' => $ctrl]))
            ->setRequirements($requestObject->requirements)
            ->setOptions($requestObject->options)
            ->setSchemes($requestObject->schemas)
            ->setMethods($requestObject->methods)
            ->setCondition($requestObject->condition)
        );
    }

    /**
     * @param $resource
     * @return string
     */
    private function getSourceDir($resource) {
        $composerJsonPath = $this->kernelRoot . '/../' . 'composer.json';
        $composerConfig = json_decode(file_get_contents($composerJsonPath));
        $psr4 = "psr-4";
        $dir = $this->alternativeAutoloadKey($composerConfig, $psr4);
        $dir .= '/' . substr($resource, 1);
        return str_replace('//', '/', $dir);
    }

    private function alternativeAutoloadKey($composerConfig, $psr4) {
        $composerObject = get_object_vars($composerConfig->autoload->$psr4);
        $composerObjectKeys = array_keys($composerObject);
        return $this->kernelRoot . '/../' . $composerObject[$composerObjectKeys[0]];
    }

    /**
     * @param $resource
     * @param SplFileInfo $file
     * @return \ReflectionClass
     */
    private function getClassReflectionFromFile($resource, SplFileInfo $file) {
        $namespace = substr($resource, 1) . substr($file->getRelativePathname(), 0, -4);
        $namespace = str_replace('/', '\\', $namespace);
        return new \ReflectionClass($namespace);
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return bool
     */
    public function supports($resource, $type = null) {
        return $type === 'km_api';
    }
}