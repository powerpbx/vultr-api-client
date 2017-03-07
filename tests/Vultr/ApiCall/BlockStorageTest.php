<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class BlockStorageTest extends TestCase
{
    /**
     * @var VultrClient
     */
    protected $client;

    /**
     * @var JsonData
     */
    protected $jsonData;

    protected function setUp()
    {
        $adapterClass = 'Vultr\Adapter\\' . getenv('ADAPTER');

        $adapter = new $adapterClass(getenv('APITOKEN'));
        $adapter->setEndpoint(getenv('ENDPOINT'));

        $this->client = new VultrClient($adapter);
    }

    public function testGetList()
    {
        $result = $this->client->blockStorage()->getList();

        $this->assertArrayHasKey('SUBID', array_shift($result));
    }

    public function testAttach()
    {
        $result = $this->client->blockStorage()->attach(1, 2);

        $this->assertInternalType('int', $result);
    }

    public function testCreate()
    {
        $result = $this->client->blockStorage()->create(1, 20, 'test');

        $this->assertArrayHasKey('USERID', $result);
    }

    public function testDelete()
    {
        $result = $this->client->blockStorage()->delete(1);

        $this->assertInternalType('int', $result);
    }

    public function testDetach()
    {
        $result = $this->client->blockStorage()->detach(1);

        $this->assertInternalType('int', $result);
    }

    public function testSetLabel()
    {
        $result = $this->client->blockStorage()->setLabel(1, 'test');

        $this->assertInternalType('int', $result);
    }

    public function testResize()
    {
        $result = $this->client->blockStorage()->resize(1, 25);

        $this->assertInternalType('int', $result);
    }
}
