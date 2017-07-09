<?php

namespace ApiBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_client")
 */
class OAuthClient extends Client {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

}