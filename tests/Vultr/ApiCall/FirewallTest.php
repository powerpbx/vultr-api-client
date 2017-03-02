<?php

namespace Vultr\Tests;

use Vultr\VultrClient;

class FirewallTest extends \PHPUnit_Framework_TestCase
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

    public function testCreateGroup()
    {
        $result = $this->client->firewall()->createGroup('test');

        $this->assertInternalType('string', $result);
    }

    public function testDeleteGroup()
    {
        $result = $this->client->firewall()->deleteGroup('1234abcd');

        $this->assertInternalType('int', $result);
    }

    public function testGetGroupList()
    {
        $result = $this->client->firewall()->getGroupList();

        $this->assertArrayHasKey('FIREWALLGROUPID', array_shift($result));
    }

    public function testSetGroupDescription()
    {
        $result = $this->client->firewall()->setGroupDescription('1234abcd', 'test');

        $this->assertInternalType('int', $result);
    }

    public function testCreateRule()
    {
        $result = $this->client->firewall()->createRule(
            '1234abcd',
            'v4',
            'gre',
            '127.0.0.1',
            25,
            443
        );

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Ip type must be one of .*\.#
     */
    public function testCreateRuleExceptionIpType()
    {
        $this->client->firewall()->createRule(
            '1234abcd',
            'v42',
            'tcp',
            '127.0.0.1',
            25,
            443
        );
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Protocol must be one of .*\.#
     */
    public function testCreateRuleExceptionProtocol()
    {
        $this->client->firewall()->createRule(
            '1234abcd',
            'v4',
            'great',
            '127.0.0.1',
            25,
            443
        );
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Direction must be one of .*\.#
     */
    public function testCreateRuleExceptionDirection()
    {
        $this->client->firewall()->createRule(
            '1234abcd',
            'v4',
            'icmp',
            '127.0.0.1',
            25,
            443,
            'out'
        );
    }

    public function testDeleteRule()
    {
        $result = $this->client->firewall()->deleteRule('1234abcd', 3);

        $this->assertInternalType('int', $result);
    }

    public function testGetRuleList()
    {
        $result = $this->client->firewall()->getRuleList(1, 'v4');

        $this->assertArrayHasKey('rulenumber', array_shift($result));
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Ip type must be one of .*\.#
     */
    public function testGetRuleListExceptionIpType()
    {
        $this->client->firewall()->getRuleList(1, 'v42');
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Direction must be one of .*\.#
     */
    public function testGetRuleListExceptionDirection()
    {
        $this->client->firewall()->getRuleList(1, 'v6', 'out');
    }
}
