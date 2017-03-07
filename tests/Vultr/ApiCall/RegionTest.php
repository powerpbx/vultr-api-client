<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class RegionTest extends TestCase
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
        $result = $this->client->region()->getList();

        $this->assertArrayHasKey('DCID', array_shift($result));
    }

    public function testGetAvailability()
    {
        $result = $this->client->region()->getAvailability(1);

        $this->assertContainsOnly('int', $result);
    }
}
