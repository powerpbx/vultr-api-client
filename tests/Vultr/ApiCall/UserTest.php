<?php

namespace Vultr\Tests;

use Vultr\Tests\JsonData;
use Vultr\VultrClient;

class UserTest extends \PHPUnit_Framework_TestCase
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
