<?php

namespace AppBundle\RequestBuilders\Client\Traits;

use AppBundle\Entity\Client;

/**
 * Class IsAdminOrOwner
 * @package AppBundle\RequestBuilders\Client\Traits
 */
trait IsAdminOrOwner {

    /**
     * @param Client $user
     * @return boolean
     */
    public function authenticate($user) {
        if($user instanceof Client) {
            if($user->isSuperAdmin()) {
                return true;
            } else {
                return $user === $this->request->shippingAddress->getClient();
            }
        }
        return false;
    }

}