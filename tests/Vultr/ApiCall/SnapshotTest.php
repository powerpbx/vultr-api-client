<?php

namespace Vultr\Tests;

use Vultr\Adapter\CurlAdapter;
use Vultr\VultrClient;

class SnapshotTest extends \PHPUnit_Framework_TestCase
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
        $result = $this->client->snapshot()->getList();

        $this->assertArrayHasKey('SNAPSHOTID', array_shift($result));
    }

    public function testCreate()
    {
        $result = $this->client->snapshot()->create(125584, 'Backup 20160122');

        $this->assertInternalType('string', $result);
    }

    public function testDestroy()
    {
        $result = $this->client->snapshot()->destroy('544e52f31c706');

        $this->assertInternalType('int', $result);
    }
}
