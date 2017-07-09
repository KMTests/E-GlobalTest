<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Client;
use AppBundle\Entity\ShippingAddress;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Factory as Faker;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;

/**
 * Class LoadUserData
 * @package ApiBundle\DataFixtures\ORM
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface {

    const DEFAULT_PASSWORD = 'password';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var UserManipulator
     */
    protected $userManipulator;

    /**
     * @var Faker
     */
    protected $faker;

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
        $this->userManipulator = $this->container->get('fos_user.util.user_manipulator');
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $this->faker = Faker::create();
        $this->em = $manager;
        $this->createAdmin('admin@demo.com');
        $this->createUser('user@demo.com');
        $manager->flush();
    }

    /**
     * @param string $email
     * @param string $password
     */
    private function createAdmin($email, $password=LoadUserData::DEFAULT_PASSWORD) {
        $user = $this->userManipulator->create($email, $password, $email, true, true);
        $user = $this->lazyClientCheck($user);
        $user->setFirstName($this->faker->firstName);
        $user->setLastName($this->faker->lastName);
        $this->createAddress($user, 3);
    }

    /**
     * @param string $email
     * @param string $password
     */
    private function createUser($email, $password=LoadUserData::DEFAULT_PASSWORD) {
        $user = $this->userManipulator->create($email, $password, $email, true, false);
        $user = $this->lazyClientCheck($user);
        $user->setFirstName($this->faker->firstName);
        $user->setLastName($this->faker->lastName);
        $this->createAddress($user, 2);
    }

    /**
     * @param Client $user
     * @param int $amount
     */
    private function createAddress(Client $user, $amount=3) {
        for($i = 0; $i < $amount; $i++) {
            $address = new ShippingAddress();
            $i === 0 ? $address->setDefaultAddress(true) : $address->setDefaultAddress(false);
            $address
                ->setClient($user)->setCity($this->faker->city)
                ->setCountry($this->faker->country)
                ->setStreet($this->faker->streetAddress)
                ->setZipcode($this->faker->postcode);
            $this->em->persist($address);
            $user->addShippingAddress($address);
        }
    }

    /**
     * @param Client $client
     * @return Client
     */
    private function lazyClientCheck(Client $client) {
        return $client;
    }

}