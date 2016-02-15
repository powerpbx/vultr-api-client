<?php

namespace Vultr\Tests;

use Vultr\Tests\JsonData;
use Vultr\VultrClient;

class ReservedIpTest extends \PHPUnit_Framework_TestCase
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
        $result = $this->client->reservedIp()->getList();

        $this->assertArrayHasKey('subnet', array_shift($result));
    }

    public function testAttach()
    {
        $result = $this->client->reservedIp()->attach('127.0.0.1', 1255);

        $this->assertInternalType('int', $result);
    }

    public function testDetach()
    {
        $result = $this->client->reservedIp()->detach('127.0.0.1', 1255);

        $this->assertInternalType('int', $result);
    }

    public function testCreate()
    {
        $result = $this->client->reservedIp()->create(1, 'v6');

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #IP type must be one of .*\.#
     */
    public function testCreateException()
    {
        $this->client->reservedIp()->create(1, 'v42');
    }

    public function testDestroy()
    {
        $result = $this->client->reservedIp()->destroy(1);

        $this->assertInternalType('int', $result);
    }
}
