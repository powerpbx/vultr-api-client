<?php

/**
 * Vultr.com PHP API
 *
 * @package Vultr
 * @version 1.0
 * @author  https://github.com/malc0mn - https://github.com/usefulz
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see     https://github.com/malc0mn/vultr-api-client
 */

namespace Vultr\Adapter;

class AdapterInterface
{
    /**
     * API Token
     *
     * @see https://my.vultr.com/settings/
     *
     * @var string $api_token Vultr.com API token
     */
    private $apiToken;


    /**
     * The API responsecode
     *
     * @var int
     */
    private $responseCode;

    /**
     * Constructor.
     *
     * @param string $apiToken
     */
    public function __construct($apiToken);

    /**
     * GET Method
     *
     * @param string $method
     * @param mixed $args
     *
     * @return mixed
     */
    public function get($method, $args = false);

    /**
     * POST Method
     *
     * @param string $method
     * @param mixed $args
     * @param boolean $getCode whether or not to return the HTTP response code.
     */
    public function post($method, $args, $getCode = false);
}
