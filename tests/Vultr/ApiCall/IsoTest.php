<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class IsoTest extends TestCase
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
        $result = $this->client->iso()->getList();

        $this->assertArrayHasKey('ISOID', array_shift($result));
    }

    public function testCreateFromUrl()
    {
        $result = $this->client->iso()->createFromUrl('http://example.com/path/to/CentOS-6.5-x86_64-minimal.iso');

        $this->assertInternalType('int', $result);
    }
}
