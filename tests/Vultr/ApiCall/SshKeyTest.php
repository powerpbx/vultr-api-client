<?php

namespace Vultr\Tests;

use Vultr\VultrClient;

class SshKeyTest extends \PHPUnit_Framework_TestCase
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
        $result = $this->client->sshKey()->getList();

        $this->assertArrayHasKey('SSHKEYID', array_shift($result));
    }

    public function testCreate()
    {
        $result = $this->client->sshKey()->create('My key', 'someverylongstringthatshouldrepresentsshkeycontent...yaddayadda');

        $this->assertInternalType('string', $result);
    }

    public function testUpdateName()
    {
        $result = $this->client->sshKey()->update('541b4960f23bd', 'My key renamed');

        $this->assertInternalType('int', $result);
    }

    public function testUpdateKey()
    {
        $result = $this->client->sshKey()->update('541b4960f23bd', null, 'someverylongstringthatshouldrepresentsshkeycontent...neeeeeewkeycontent==');

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #Please provide name or key to update for key ID .*!#
     */
    public function testUpdateException()
    {
        $this->client->sshKey()->update('541b4960f23bd');
    }

    public function testDestroy()
    {
        $result = $this->client->sshKey()->destroy('541b4960f23bd');

        $this->assertInternalType('int', $result);
    }
}
