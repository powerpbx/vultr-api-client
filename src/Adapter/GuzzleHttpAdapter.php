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
use Vultr\Exception\ApiException;
use Vultr\VultrClient;

class GuzzleHttpAdapter extends AbstractAdapter
{
    /**
     * API Token
     *
     * @see https://my.vultr.com/settings/
     *
     * @var string $api_token Vultr.com API token
     */
    protected $apiToken;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Response|ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $postOptions;

    /**
     * @var integer
     */
    protected $guzzleVersion;

    /**
     * @param string $apiToken Vultr API token
     *
     * @throws \RuntimeException
     */
    public function __construct($apiToken)
    {
        if (version_compare(ClientInterface::VERSION, '6') === 1) {
            $this->guzzleVersion = 6;
            $this->postOptions = 'form_params';
        } else if (version_compare(ClientInterface::VERSION, '5') === 1) {
            $this->guzzleVersion = 5;
            $this->postOptions = 'body';
        } else {
            throw new \RuntimeException('Unsupported guzzle version! Install guzzle 5 or 6.');
        }

        $this->apiToken = $apiToken;
        $this->buildClient();
    }

    /**
     * Helper function to build the Guzzle HTTP client.
     *
     * @param string $apiToken Vultr API token
     * @param string $endpoint API endpoint
     *
     * @return array
     */
    protected function buildClient($endpoint = null)
    {
        if ($endpoint === null) {
            $endpoint = VultrClient::ENDPOINT;
        }

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
                'api_key' => $this->apiToken,
            ],
        ];

        switch ($this->guzzleVersion) {
            case 5:
                $config = [
                    'base_url' => $endpoint,
                    'defaults' => $config,
                ];
                break;
            case 6:
                $config['base_uri'] = $endpoint;
                break;
        }

        $this->client = new Client($config);
    }

    /**
     * {@inheritdoc}
     */
    public function setEndpoint($endpoint)
    {
        $this->buildClient($endpoint);
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $args = [])
    {
        $options = [];

        // Add additional arguments to the defaults:
        //   Guzzle 6 does no longer merge the default query params with the
        //   additional params given here!
        if (!empty($args)) {
            if ($this->guzzleVersion > 5) {
                $options['query'] = array_merge(
                    $this->client->getConfig('query'),
                    $args
                );
            } else {
                $options['query'] = $args;
            }
        }

        try {
            $this->response = $this->client->get($url, $options);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            return $this->handleError();
        }

        // $response->json() is not compatible with Guzzle 6.
        return json_decode($this->response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, array $args, $getCode = false)
    {
        $options[$this->postOptions] = $args;

        try {
            $this->response = $this->client->post($url, $options);

            if ($getCode) {
                return (int) $this->response->getStatusCode();
            }
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            return $this->handleError($getCode);
        }

        // $response->json() is not compatible with Guzzle 6.
        return json_decode($this->response->getBody(), true);
    }

    /**
     * @throws ApiException
     */
    protected function handleError($getCode = false)
    {
        $code = (int) $this->response->getStatusCode();

        if ($getCode) {
            return $code;
        }

        $content = (string) $this->response->getBody();

        $this->reportError($code, $content);
    }
}
