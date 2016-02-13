<?php

/**
 * Vultr.com PHP API Client
 *
 * @package Vultr
 * @version 1.0
 * @author  https://github.com/malc0mn
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see     https://github.com/malc0mn/vultr-api-client
 */

namespace Vultr\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Vultr\VultrClient;

class GuzzleHttpAdapter implements AdapterInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Response|ResponseInterface
     */
    protected $response;


    /**
     * @param string $apiToken Vultr API token
     */
    public function __construct($apiToken)
    {
        if (version_compare(ClientInterface::VERSION, '6') === 1) {
            $version = 6;
        } else if (version_compare(ClientInterface::VERSION, '5') === 1) {
            $version = 5;
        } else {
            throw new \RuntimeException('Unsupported guzzle version! Install guzzle 5 or 6.');
        }

        $this->client = new Client(
            $this->guzzleConfig($apiToken, $version)
        );
    }

    /**
     * Helper function to return Guzzle config.
     *
     * @param string  $apiToken Vultr API token
     * @param integer $version Guzzle version
     * @return array
     */
    protected function guzzleConfig($apiToken, $version)
    {
        $config = [
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => sprintf('%s v%s (%s)',
                    VultrClient::AGENT,
                    VultrClient::VERSION,
                    'https://github.com/malc0mn/vultr-api-client'
                ),
            ],
            'query' => [
                'api_key' => $apiToken,
            ],
        ];

        switch ($version) {
            case 5:
                $config = [
                    'base_url' => VultrClient::ENDPOINT,
                    'defaults' => $config,
                ];
                break;
            case 6:
                $config['base_uri'] = VultrClient::ENDPOINT;
                break;
        }

        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $args = [])
    {
        $options = [];

        if (!empty($args)) {
            $options['query'] = $args;
        }

        try {
            $this->response = $this->client->get($url, $options);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return json_decode($this->response->getBody());
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, array $args, $getCode = false)
    {
        $options['json'] = $args;

        try {
            $this->response = $this->client->post($url, $options);

            if ($getCode) {
                return (int) $this->response->getStatusCode();
            }

        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return json_decode($this->response->getBody());
    }

    /**
     * @throws \Exception
     */
    protected function handleError()
    {
        $body = (string) $this->response->getBody();
        $code = (int) $this->response->getStatusCode();

        $content = json_decode($body);

        throw new \Exception(isset($content->message) ? $content->message : 'Unable to process request.', $code);
    }
}
