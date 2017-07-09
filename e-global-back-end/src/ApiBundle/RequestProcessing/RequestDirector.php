<?php

namespace ApiBundle\RequestProcessing;

use ApiBundle\Annotations\Api\Map;
use ApiBundle\Annotations\Api\Resolve;
use ApiBundle\ClassBuilder\ClassFactory;
use ApiBundle\ClassBuilder\ExposedContainer;
use ApiBundle\Entity\User;
use ApiBundle\Exceptions\SecurityException;
use ApiBundle\RequestProcessing\RequestFactory\RequestResolverInterface;
use ApiBundle\RequestProcessing\RequestParameterResolvers\RequestParameterResolverInterface;
use ApiBundle\Validator\RequestValidator;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class RequestDirector
 * @package ApiBundle\RequestProcessing
 */
class RequestDirector {

    /**
     * @var RequestResolverInterface
     */
    protected $requestResolver;

    /**
     * @var BaseRequestBuilder
     */
    protected $requestBuilder;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * @var ClassFactory
     */
    private $classFactory;

    /**
     * @var RequestValidator
     */
    private $validator;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * RequestDirector constructor.
     * @param RequestResolverInterface $requestResolver
     * @param TokenStorage $tokenStorage
     * @param ExposedContainer $exposedContainer
     * @param ClassFactory $classFactory
     * @param RequestValidator $validator
     * @param ContainerInterface $container
     */
    public function __construct(
        RequestResolverInterface $requestResolver,
        TokenStorage $tokenStorage,
        ExposedContainer $exposedContainer,
        ClassFactory $classFactory,
        RequestValidator $validator,
        ContainerInterface $container
    ) {
        $this->requestResolver = $requestResolver;
        $this->tokenStorage = $tokenStorage;
        $this->exposedContainer = $exposedContainer;
        $this->classFactory = $classFactory;
        $this->validator = $validator;
        $this->container = $container;
    }

    /**
     * @param BaseRequestBuilder $requestBuilder
     * @throws SecurityException
     */
    public function processRequest(BaseRequestBuilder $requestBuilder) {
        $this->requestBuilder = $requestBuilder;
        $this->exposedContainer->expose($this->requestBuilder);
        $user = $this->tokenStorage->getToken()->getUser();
        $this->exposedContainer->expose($user, [User::class, 'logged_in_user']);
        $this->createRequestObject();
        if(!$this->requestBuilder->authenticate($user)) {
            throw new SecurityException('exception.security.not_allowed');
        }
    }

    private function createRequestObject() {
        if($this->requestBuilder->request) {
            $this->requestBuilder->request = $this->classFactory->createFromNamespace($this->requestBuilder->request);
            $this->requestResolver->resolveParameters();
            $requestReflection = new \ReflectionClass($this->requestBuilder->request);
            $annotationReader = new AnnotationReader();
            foreach ($requestReflection->getProperties() as $property) {
                $map = $annotationReader->getPropertyAnnotation($property, Map::class);
                if($map instanceof Map) {
                    $resolvable = $annotationReader->getPropertyAnnotation($property, Resolve::class);
                    $value = $this->requestResolver->get($map->value);
                    if($resolvable instanceof Resolve) {
                        /** @var RequestParameterResolverInterface $resolver */
                        $resolver = $this->container->get($resolvable->resolver);
                        $value = $resolver->resolve($value, $resolvable->value);
                        if(is_object($value)) {
                            $this->exposedContainer->expose($value);
                        }
                    }
                    $this->requestBuilder->request->{$property->getName()} = $value;
                }
            }
            $this->validator->validate($this->requestBuilder->request);
        }
    }

    /**
     * @return BaseRequestBuilder
     */
    public function getRequestBuilder() {
        return $this->requestBuilder;
    }

}