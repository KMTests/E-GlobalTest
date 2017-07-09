<?php

namespace ApiBundle\RequestProcessing\RequestParameterResolvers;

/**
 * Interface RequestParameterResolverInterface
 * @package ApiBundle\RequestProcessing\RequestParameterResolvers
 */
interface RequestParameterResolverInterface {

    /**
     * @param $requestValue
     * @param $resolverValue
     * @return mixed
     */
    public function resolve($requestValue, $resolverValue);

}