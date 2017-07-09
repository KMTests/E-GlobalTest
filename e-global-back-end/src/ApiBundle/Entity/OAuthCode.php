<?php

namespace ApiBundle\Entity;

use FOS\OAuthServerBundle\Entity\AuthCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_code")
 */
class OAuthCode extends AuthCode {

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