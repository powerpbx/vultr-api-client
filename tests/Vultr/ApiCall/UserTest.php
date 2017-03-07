<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class UserTest extends TestCase
{
    /**
     * @var VultrClient
     */
    protected $client;

    protected function setUp()
    {
        $adapterClass = 'Vultr\Adapter\\' . getenv('ADAPTER');

        $adapter = new $adapterClass(getenv('APITOKEN'));
        $adapter->setEndpoint(getenv('ENDPOINT'));

        $this->client = new VultrClient($adapter);
    }

    public function testGetList()
    {
        $result = $this->client->user()->getList();

        $this->assertArrayHasKey('USERID', $result[0]);
    }

    public function testCreate()
    {
        $result = $this->client->user()->create('try.to@guess.it', 'jules', 'somepass', []);

        $this->assertArrayHasKey('USERID', $result);
    }

    public function testUpdate()
    {
        $result = $this->client->user()->update(6, 'try.to@guess.it');

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException        \Vultr\Exception\ApiException
     * @expectedExceptionMessage Please provide at least one parameter to update!
     */
    public function testUpdateException()
    {
        $this->client->user()->update('564a1a7794d83');
    }

    public function testDelete()
    {
        $result = $this->client->user()->delete('564a1a7794d83');

        $this->assertInternalType('int', $result);
    }
}
