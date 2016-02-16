<?php

namespace Vultr\Tests;

use Vultr\VultrClient;

class VultrClientTest extends \PHPUnit_Framework_TestCase
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
