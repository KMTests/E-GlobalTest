<?php

namespace ApiBundle\Controller;

use ApiBundle\ClassBuilder\ExposedContainer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ApiController
 * @package ApiBundle\Controller
 */
abstract class ApiController extends Controller {

    /**
     * @var ExposedContainer
     */
    private $exposedContainer;

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if($name == 'view') {
            return $this->createView();
        }
        return null;
    }

    /**
     * @return mixed
     */
    protected function createView() {
        return $this->get('kmapi.view.builder')->create();
    }

    /**
     * @param object $class
     */
    protected function exposeClass($class) {
        if(!$this->exposedContainer) {
            $this->exposedContainer = $this->get('kmapi.exposed.container');
        }
        $this->exposedContainer->expose($class);
    }

}