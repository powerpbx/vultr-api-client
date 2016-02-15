<?php

namespace Vultr\Tests;

use Vultr\Tests\JsonData;
use Vultr\VultrClient;

class DnsTest extends \PHPUnit_Framework_TestCase
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
        $result = $this->client->dns()->getList();

        $this->assertArrayHasKey('domain', $result[0]);
    }

    public function testGetRecords()
    {
        $result = $this->client->dns()->getRecords('example.com');

        $this->assertArrayHasKey('RECORDID', $result[0]);
    }

    public function testCreateDomain()
    {
        $result = $this->client->dns()->createDomain('example.com', '127.0.0.1');

        $this->assertInternalType('int', $result);
    }

    public function testDeleteDomain()
    {
        $result = $this->client->dns()->deleteDomain(5);

        $this->assertInternalType('int', $result);
    }

    public function testCreateRecord()
    {
        $result = $this->client->dns()->createRecord('example.com', 'www', 'A', 'data');

        $this->assertInternalType('int', $result);
    }

    public function testGetOsList()
    {
        $result = $this->client->dns()->updateRecord(5, 'example.com', 'www', 'A', 'data');

        $this->assertInternalType('int', $result);
    }

    public function testGetPlansList()
    {
        $result = $this->client->dns()->deleteRecord('example.com', 5);

        $this->assertInternalType('int', $result);
    }
}
