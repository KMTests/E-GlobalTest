<?php

namespace ApiBundle\Factories;

use Symfony\Component\Routing\Route;

/**
 * Class RouteFactory
 * @package ApiBundle\Factories
 */
class RouteFactory {

    /**
     * @param string $path
     * @return Route
     */
    public function create($path) {
        return new Route($path);
    }

}