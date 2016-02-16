<?php

namespace Vultr\Tests;

use Vultr\Adapter\GuzzleHttpAdapter;

class GuzzleHttpAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GuzzleHttpAdapter;
     */
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttpAdapter('EXAMPLE');
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('Vultr\Adapter\GuzzleHttpAdapter', $this->client);
    }

    /**
     * @expectedException        \Vultr\Exception\ApiException
     * @expectedExceptionMessage Invalid or missing API key. Check that your API key is present and matches your assigned key.
     */
    public function testGet()
    {
        $result = $this->client->get('account/info');

        $this->assertContains('Invalid or missing API key. Check that your API key is present and matches your assigned key.', $result);

        // Prevent rate limit.
        sleep(1);
    }

    /**
     * @expectedException        \Vultr\Exception\ApiException
     * @expectedExceptionMessage Invalid or missing API key. Check that your API key is present and matches your assigned key.
     */
    public function testPost()
    {
        $result = $this->client->post('user/create', []);

        $this->assertContains('Invalid or missing API key. Check that your API key is present and matches your assigned key.', $result);

        // Prevent rate limit.
        sleep(1);
    }

    /**
     * @expectedException        \Vultr\Exception\ApiException
     * @expectedExceptionMessage Invalid HTTP method. Check that the method (POST|GET) matches what the documentation indicates.
     */
    public function testWrongPost()
    {
        $result = $this->client->post('account/info', []);

        $this->assertContains('Invalid HTTP method. Check that the method (POST|GET) matches what the documentation indicates.', $result);

        // Prevent rate limit.
        sleep(1);
    }

    /**
     * @expectedException        \Vultr\Exception\ApiException
     * @expectedExceptionMessage Invalid API location. Check the URL that you are using.
     */
    public function testInvalidUrl()
    {
        $result = $this->client->post('unknown/url', []);

        $this->assertContains('Invalid API location. Check the URL that you are using.', $result);

        // Prevent rate limit.
        sleep(1);
    }
}
