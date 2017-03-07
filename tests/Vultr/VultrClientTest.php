<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class VultrClientTest extends TestCase
{
    public function testConstruct()
    {
        $adapterClass = 'Vultr\Adapter\\' . getenv('ADAPTER');

        $adapter = new $adapterClass(getenv('APITOKEN'));
        $adapter->setEndpoint(getenv('ENDPOINT'));

        $client = new VultrClient($adapter);

        $this->assertInstanceOf('Vultr\VultrClient', $client);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    /*public function testConstructException()
    {
        $this->jsonData = new JsonData();

        $mockAdapter = $stub = $this->getMockBuilder('NonExistentAdapter')
            ->getMock();

        $this->client = new VultrClient($mockAdapter);
    }*/
}
