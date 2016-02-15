<?php

namespace Vultr\Tests;

use Vultr\Tests\JsonData;
use Vultr\VultrClient;

class RegionTest extends \PHPUnit_Framework_TestCase
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
        $result = $this->client->region()->getList();

        $this->assertArrayHasKey('DCID', array_shift($result));
    }

    public function testGetAvailability()
    {
        $result = $this->client->region()->getAvailability(1);

        $this->assertContainsOnly('int', $result);
    }
}
