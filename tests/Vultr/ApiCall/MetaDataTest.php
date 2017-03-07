<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class MetaDataTest extends TestCase
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

    public function testGetAccountInfo()
    {
        $result = $this->client->metaData()->getAccountInfo();

        $this->assertArrayHasKey('balance', $result);
    }

    public function testGetAppList()
    {
        $result = $this->client->metaData()->getAppList();

        $this->assertArrayHasKey('APPID', array_shift($result));
    }

    public function testGetAuthInfo()
    {
        $result = $this->client->metaData()->getAuthInfo();

        $this->assertArrayHasKey('email', $result);
    }

    public function testGetBackupList()
    {
        $result = $this->client->metaData()->getBackupList();

        $this->assertArrayHasKey('BACKUPID', array_shift($result));
    }

    public function testGetIsoList()
    {
        $result = $this->client->metaData()->getIsoList();

        $this->assertArrayHasKey('ISOID', array_shift($result));
    }

    public function testGetOsList()
    {
        $result = $this->client->metaData()->getOsList();

        $this->assertArrayHasKey('OSID', array_shift($result));
    }

    public function testGetPlansList()
    {
        $result = $this->client->metaData()->getPlansList();

        $this->assertArrayHasKey('VPSPLANID', array_shift($result));
    }

    public function testGetPlansListFilteredByType()
    {
        $result = $this->client->metaData()->getPlansList('ssd');

        $this->assertArraySubset(['plan_type' => 'SSD'], array_shift($result));
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Type must be one of .*\.#
     */
    public function testGetPlansListFilteredByTypeException()
    {
        $this->client->metaData()->getPlansList('test');
    }

    public function testGetPlansVc2List()
    {
        $result = $this->client->metaData()->getPlansListVc2();

        $this->assertArrayHasKey('VPSPLANID', array_shift($result));
    }

    public function testGetPlansVdc2List()
    {
        $result = $this->client->metaData()->getPlansListVdc2();

        $this->assertArrayHasKey('VPSPLANID', array_shift($result));
    }
}
