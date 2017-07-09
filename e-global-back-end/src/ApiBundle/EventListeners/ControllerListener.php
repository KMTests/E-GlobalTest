<?php

namespace ApiBundle\EventListeners;

use ApiBundle\Annotations\Api\Request;
use ApiBundle\ClassBuilder\ClassFactory;
use ApiBundle\Factories\AnnotationReaderFactory;
use ApiBundle\RequestProcessing\RequestDirector;
use ApiBundle\RequestProcessing\ViewBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ControllerListener
 * @package ApiBundle\EventListeners
 */
class ControllerListener {

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @var RequestDirector
     */
    private $requestDirector;

    /**
     * @var ClassFactory
     */
    private $classFactory;

    /**
     * @var ViewBuilder
     */
    private $viewBuilder;

    /**
     * ControllerListener constructor.
     * @param RequestDirector $requestDirector
     * @param ViewBuilder $viewBuilder
     * @param ClassFactory $classFactory
     * @param AnnotationReaderFactory $annotationReaderFactory
     */
    public function __construct(
        RequestDirector $requestDirector,
        ViewBuilder $viewBuilder,
        ClassFactory $classFactory,
        AnnotationReaderFactory $annotationReaderFactory
    ) {
        $this->annotationReader = $annotationReaderFactory->create();
        $this->requestDirector = $requestDirector;
        $this->classFactory = $classFactory;
        $this->viewBuilder = $viewBuilder;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event) {
        $controller = $event->getController();
        $builderAnnotation = $this->annotationReader->getMethodAnnotation(
            new \ReflectionMethod($controller[0], $controller[1]),
            Request::class
        );
        if($builderAnnotation instanceof Request) {
            $builder = $this->classFactory->createFromNamespace($builderAnnotation->value);
            $this->requestDirector->processRequest($builder);
        }
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $response = $this->viewBuilder->createError($event->getException());
        if($response) {
            $event->allowCustomResponseCode();
            $event->setResponse($response);
        }
    }

}