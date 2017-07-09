<?php

namespace ApiBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_access_token")
 */
class OAuthAccessToken extends AccessToken {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OAuthClient")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;

}