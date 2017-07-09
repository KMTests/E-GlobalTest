<?php

namespace ApiBundle\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_refresh_token")
 */
class OAuthRefreshToken extends RefreshToken {

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