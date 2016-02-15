<?php

namespace Vultr\Tests;

use Vultr\VultrClient;

class VultrClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $mockAdapter = $stub = $this->getMockBuilder('Vultr\Adapter\CurlAdapter')
            ->setConstructorArgs(['EXAMPLE'])
            ->getMock();

        $client = new VultrClient($mockAdapter);

        $this->assertInstanceOf('Vultr\VultrClient', $client);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testConstructException()
    {
        $this->jsonData = new JsonData();

        $mockAdapter = $stub = $this->getMockBuilder('NonExistentAdapter')
            ->getMock();

        $this->client = new VultrClient($mockAdapter);
    }
}
