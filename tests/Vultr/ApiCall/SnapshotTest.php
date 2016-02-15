<?php

namespace Vultr\Tests;

use Vultr\Tests\JsonData;
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
        $this->jsonData = new JsonData();

        $mockAdapter = $stub = $this->getMockBuilder('Vultr\Adapter\CurlAdapter')
            ->setConstructorArgs(['EXAMPLE'])
            ->getMock();

        $mockAdapter->method('get')
            ->will(
                $this->returnCallback([$this->jsonData, 'getResponse'])
            )
        ;

        $mockAdapter->method('post')
            ->will(
                $this->returnCallback([$this->jsonData, 'getResponse'])
            )
        ;

        $this->client = new VultrClient($mockAdapter);
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
