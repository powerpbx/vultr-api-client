<?php

namespace Vultr\Tests;

use Vultr\VultrClient;

class StartupScriptTest extends \PHPUnit_Framework_TestCase
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
        $result = $this->client->startupScript()->getList();

        $this->assertArrayHasKey('SCRIPTID', array_shift($result));
    }

    public function testCreate()
    {
        $result = $this->client->startupScript()->create('Hello world script', '#!/bin/bash echo Hello World > /root/hello', 'boot');

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Script type must be one of .*.#
     */
    public function testCreateException()
    {
        $this->client->startupScript()->create('Hello world script', '#!/bin/bash echo Hello World > /root/hello', 'ooops');
    }

    public function testUpdateName()
    {
        $result = $this->client->startupScript()->update(3, 'Hello world renamed');

        $this->assertInternalType('int', $result);
    }

    public function testUpdateScript()
    {
        $result = $this->client->startupScript()->update(3, null, '#!/bin/bash echo Hello Dude > /root/hello');

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Please provide name or script to update for script ID .*!#
     */
    public function testUpdateException()
    {
        $this->client->startupScript()->update(3);
    }

    public function testDestroy()
    {
        $result = $this->client->startupScript()->destroy(3);

        $this->assertInternalType('int', $result);
    }
}
