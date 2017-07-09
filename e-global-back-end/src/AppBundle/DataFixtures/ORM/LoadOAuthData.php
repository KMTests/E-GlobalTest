<?php

namespace AppBundle\DataFixtures\ORM;

use ApiBundle\Entity\OAuthClient;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\OAuthServerBundle\Entity\ClientManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadOAuthData
 * @package ApiBundle\DataFixtures\ORM
 */
class LoadOAuthData implements FixtureInterface, ContainerAwareInterface {

    const ENV_CLIENT_ID = 'E_GLOBAL_API_CLIENT_ID';
    const ENV_CLIENT_SECRET = 'E_GLOBAL_API_SECRET_ID';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        /** @var ClientManager $clientManager */
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array('http://www.example.com'));
        $client->setAllowedGrantTypes(array('refresh_token', 'token', 'password', 'client_credentials'));
        $this->loadClienFromEnv($client);
        $clientManager->updateClient($client);
    }

    /**
     * @param OAuthClient $client
     */
    private function loadClienFromEnv(OAuthClient $client) {
        $clientId = getenv(self::ENV_CLIENT_ID);
        $clientSecret = getenv(self::ENV_CLIENT_SECRET);
        !$clientId ?: $client->setRandomId($clientId);
        !$clientSecret ?: $client->setSecret($clientSecret);
    }

}