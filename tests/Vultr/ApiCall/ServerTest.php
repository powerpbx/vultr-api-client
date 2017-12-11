<?php

namespace Vultr\Tests;

use PHPUnit\Framework\TestCase;
use Vultr\VultrClient;

class ServerTest extends TestCase
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

    public function testGetByTag()
    {
        $result = $this->client->server()->getByTag('mytag');

        $this->assertArraySubset(['SUBID' => 576965], array_shift($result));
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

    public function testCreateIpv4()
    {
        $result = $this->client->server()->createIpv4(576965);

        $this->assertInternalType('int', $result);
    }

    public function testDestroyIpv4()
    {
        $result = $this->client->server()->destroyIpv4(576965, '127.0.0.1');

        $this->assertInternalType('int', $result);
    }

    public function testSetReverseIpv4()
    {
        $result = $this->client->server()->setReverseIpv4(576965, '127.0.0.1', 'rdns');

        $this->assertInternalType('int', $result);
    }

    public function testRestoreDefaultReverseIpv4()
    {
        $result = $this->client->server()->restoreDefaultReverseIpv4(576965, '127.0.0.1');

        $this->assertInternalType('int', $result);
    }

    public function testGetIpv6List()
    {
        $result = $this->client->server()->getIpv6List(576965);

        $this->assertArrayHasKey('network_size', array_shift($result));
    }

    public function testGetReverseIpv6List()
    {
        $result = $this->client->server()->getReverseIpv6List(576965);

        $this->assertArrayHasKey('reverse', array_shift($result));
    }

    public function testSetReverseIpv6()
    {
        $result = $this->client->server()->setReverseIpv6(576965, '2001:DB8:1000::100', 'rdns');

        $this->assertInternalType('int', $result);
    }

    public function testDeleteReverseIpv6()
    {
        $result = $this->client->server()->deleteReverseIpv6(576965, '2001:DB8:1000::100');

        $this->assertInternalType('int', $result);
    }

    public function testReboot()
    {
        $result = $this->client->server()->reboot(576965);

        $this->assertInternalType('int', $result);
    }

    public function testHalt()
    {
        $result = $this->client->server()->halt(576965);

        $this->assertInternalType('int', $result);
    }

    public function testStart()
    {
        $result = $this->client->server()->start(576965);

        $this->assertInternalType('int', $result);
    }

    public function testDestroy()
    {
        $result = $this->client->server()->destroy(576965);

        $this->assertInternalType('int', $result);
    }

    public function testReinstall()
    {
        $result = $this->client->server()->reinstall(576965);

        $this->assertInternalType('int', $result);
    }

    public function testSetLabel()
    {
        $result = $this->client->server()->setLabel(576965, 'name');

        $this->assertInternalType('int', $result);
    }

    public function testRestoreSnapshot()
    {
        $result = $this->client->server()->restoreSnapshot(576965, '544e52f31c706');

        $this->assertInternalType('int', $result);
    }

    public function testRestoreBackup()
    {
        $result = $this->client->server()->restoreBackup(576965, '543d34149403a');

        $this->assertInternalType('int', $result);
    }

    public function testCreate()
    {
        $result = $this->client->server()->create([
            'DCID'=> 5,
            'VPSPLANID' => 40,
            'OSID' => 148,
        ]);

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Plan ID \d+ is not available in region \d+\.#
     */
    public function testCreateUnavailable()
    {
        $this->client->server()->create([
            'DCID'=> 5,
            'VPSPLANID' => 1,
            'OSID' => 148,
        ]);
    }

    public function testGetIsoStatus()
    {
        $result = $this->client->server()->getIsoStatus(576965);

        $this->assertArrayHasKey('state', $result);
    }

    public function testSetIsoDetach()
    {
        $result = $this->client->server()->setIsoDetach(576965);

        $this->assertInternalType('int', $result);
    }

    public function testSetIsoAttach()
    {
        $result = $this->client->server()->setIsoAttach(576965, 24);

        $this->assertInternalType('int', $result);
    }

    public function testGetBackupSchedule()
    {
        $result = $this->client->server()->getBackupSchedule(576965);

        $this->assertArrayHasKey('next_scheduled_time_utc', $result);
    }

    public function testSetBackupSchedule()
    {
        $result = $this->client->server()->setBackupSchedule(
            576965,
            [
                'cron_type' => 'weekly',
                'hour' => 8,
                'dow' => 6,
            ]
        );

        $this->assertInternalType('int', $result);
    }

    public function testEnableBackup()
    {
        $result = $this->client->server()->enableBackup(576965);

        $this->assertInternalType('int', $result);
    }

    public function testDisableBackup()
    {
        $result = $this->client->server()->disableBackup(576965);

        $this->assertInternalType('int', $result);
    }
}
