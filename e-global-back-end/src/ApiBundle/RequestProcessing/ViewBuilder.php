<?php

namespace ApiBundle\RequestProcessing;

use ApiBundle\ClassBuilder\ClassFactory;
use ApiBundle\ClassBuilder\ExposedContainer;
use ApiBundle\Exceptions\ApiBaseException;
use ApiBundle\Exceptions\InternalServerException;
use ApiBundle\Responses\ApiBaseResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ViewBuilder
 * @package ApiBundle\RequestProcessing
 */
class ViewBuilder {

    /**
     * @var RequestDirector
     */
    private $requestDirector;

    /**
     * @var ClassFactory
     */
    private $classFactory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * ViewBuilder constructor.
     * @param RequestDirector $requestDirector
     * @param TranslatorInterface $translator
     * @param ClassFactory $classFactory
     * @param ExposedContainer $exposedContainer
     */
    public function __construct (
        RequestDirector $requestDirector,
        TranslatorInterface $translator,
        ClassFactory $classFactory,
        ExposedContainer $exposedContainer
    ) {
        $this->requestDirector = $requestDirector;
        $this->classFactory = $classFactory;
        $this->translator = $translator;
        $this->exposedContainer = $exposedContainer;
        $this->exposedContainer->expose($this->translator, [TranslatorInterface::class]);
    }

    /**
     * @return JsonResponse
     */
    public function create() {
        $response = $this->classFactory->createFromNamespace($this->requestDirector->getRequestBuilder()->response);
        return $this->createViewFromResponse($response);
    }

    /**
     * @param $error
     * @return JsonResponse
     */
    public function createError($error) {
        if($error instanceof ApiBaseException) {
            $this->exposedContainer->expose($error, [ApiBaseException::class]);
            $view = $this->classFactory->createFromNamespace($error->response);
            return $this->createViewFromResponse($view);
        }
    }

    /**
     * @param $response
     * @return JsonResponse
     * @throws InternalServerException
     */
    private function createViewFromResponse($response) {
        if($response instanceof ApiBaseResponse) {
            return new JsonResponse($response->getView(), $response->statusCode);
        } else {
            throw new InternalServerException('exception.class.must_extend', [
                'subject_class' => get_class($response),
                'extend_class' => ApiBaseResponse::class
            ]);
        }
    }

}