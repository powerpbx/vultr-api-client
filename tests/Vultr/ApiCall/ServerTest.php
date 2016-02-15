<?php

namespace Vultr\Tests;

use Vultr\Tests\JsonData;
use Vultr\VultrClient;

class ServerTest extends \PHPUnit_Framework_TestCase
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

    public function testAppChange()
    {
        $result = $this->client->server()->appChange(576965, 1);

        $this->assertInternalType('int', $result);
    }

    public function testGetAppChangeList()
    {
        $result = $this->client->server()->getAppChangeList(576965);

        $this->assertArrayHasKey('APPID', array_shift($result));
    }

    public function testOsChange()
    {
        $result = $this->client->server()->osChange(576965, 127);

        $this->assertInternalType('int', $result);
    }

    public function testGetOsChangeList()
    {
        $result = $this->client->server()->getOsChangeList(576965);

        $this->assertArrayHasKey('OSID', array_shift($result));
    }

    public function testUpgradePlan()
    {
        $result = $this->client->server()->upgradePlan(576965, 2);

        $this->assertInternalType('int', $result);
    }

    public function testGetUpgradePlanList()
    {
        $result = $this->client->server()->getUpgradePlanList(576965);

        $this->assertContainsOnly('int', $result);
    }

    public function testGetList()
    {
        $result = $this->client->server()->getList();

        $this->assertArrayHasKey('SUBID', array_shift($result));
    }

    public function testGetListFilteredById()
    {
        $result = $this->client->server()->getList(576965);

        $this->assertArraySubset(['SUBID' => 576965], $result);
    }

    public function testGetListFilteredByTag()
    {
        $result = $this->client->server()->getList(null, 'mytag');

        $this->assertArraySubset(['tag' => 'mytag'], array_shift($result));
    }

    public function testGetDetail()
    {
        $result = $this->client->server()->getDetail(576965);

        $this->assertArraySubset(['SUBID' => 576965], $result);
    }

    public function testGetUserData()
    {
        $result = $this->client->server()->getUserData(576965);

        $this->assertEquals('echo Hello World', $result);
    }

    public function testSetUserData()
    {
        $result = $this->client->server()->setUserData(576965, 'echo Hello World');

        $this->assertInternalType('int', $result);
    }

    public function testGetNeighbors()
    {
        $result = $this->client->server()->getNeighbors(576965);

        $this->assertContainsOnly('int', $result);
    }

    public function testGetBandwidth()
    {
        $result = $this->client->server()->getBandwidth(576965);

        $this->assertArrayHasKey('incoming_bytes', $result);
    }

    public function testGetIpv4List()
    {
        $result = $this->client->server()->getIpv4List(576965);

        $this->assertArrayHasKey('ip', array_shift($result));
    }

    public function testIpv4Create()
    {
        $result = $this->client->server()->createIpv4(576965);

        $this->assertInternalType('int', $result);
    }

    public function testDestroyIpv4()
    {
        $result = $this->client->server()->destroyIpv4(576965, '127.0.0.1');

        $this->assertInternalType('int', $result);
    }

    public function testReverseSetIpv4()
    {
        $result = $this->client->server()->reverseSetIpv4(576965, '127.0.0.1', 'rdns');

        $this->assertInternalType('int', $result);
    }
}
