<?php

namespace ApiBundle\RequestProcessing\RequestParameterResolvers;

use Doctrine\ORM\EntityManager;

/**
 * Class EntityParameterResolver
 * @package ApiBundle\RequestProcessing\RequestParameterResolvers
 */
class EntityParameterResolver implements RequestParameterResolverInterface {

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * EntityParameterResolver constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     * @param $entity
     * @return null|object
     */
    public function resolve($id, $entity) {
        return $this->entityManager->getRepository($entity)->find($id);
    }
}