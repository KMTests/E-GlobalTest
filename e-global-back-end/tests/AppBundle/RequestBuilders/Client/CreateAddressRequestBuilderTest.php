<?php

namespace AppBundle\RequestBuilders\Client;

use AppBundle\Entity\Client;
use AppBundle\Requests\Client\CreateAddressRequest;
use AppBundle\Responses\Client\ClientAddressResponse;

class CreateAddressRequestBuilderTest extends \PHPUnit_Framework_TestCase {

    protected $requestBuilder;

    public function __construct() {
        $this->requestBuilder = new CreateAddressRequestBuilder();
    }

    public function testPath() {
        $this->assertSame('/clients/{client_id}/addresses', $this->requestBuilder->path);
    }

    public function testDefaults() {
        $this->assertSame([], $this->requestBuilder->defaults);
    }

    public function testRequirements() {
        $this->assertSame(['client_id' => '\d+'], $this->requestBuilder->requirements);
    }

    public function testOptions() {
        $this->assertSame([], $this->requestBuilder->options);
    }

    public function testHost() {
        $this->assertSame('', $this->requestBuilder->host);
    }

    public function testSchemas() {
        $this->assertSame(["http", "https"], $this->requestBuilder->schemas);
    }

    public function testMethods() {
        $this->assertSame(["POST"], $this->requestBuilder->methods);
    }


    public function testCondition() {
        $this->assertSame('', $this->requestBuilder->condition);
    }

    public function testResponseObject() {
        $this->assertSame(ClientAddressResponse::class, $this->requestBuilder->response);
    }

    public function testRequestObject() {
        $this->assertSame(CreateAddressRequest::class, $this->requestBuilder->request);
    }

    public function testAuthentication() {
        $client = new Client();
        $client->setSuperAdmin(true);
        $this->assertSame(True, $this->requestBuilder->authenticate($client));
        $client->setSuperAdmin(false);
        $tmp = $this->requestBuilder->request;
        $this->requestBuilder->request = new CreateAddressRequest();
        $this->requestBuilder->request->client = $client;
        $this->assertSame(True, $this->requestBuilder->authenticate($client));
        $this->requestBuilder->request = $tmp;
    }

    

}