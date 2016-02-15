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

use Vultr\Exception\ApiException;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * Throw error with explanation of what happened.
     *
     * @param integer $code
     * @param string $response
     *
     * @throws ApiException
     */
    public function reportError($code, $response) {
        switch($code) {
            case 400:
                throw new ApiException('Invalid API location. Check the URL that you are using.');
                break;
            case 403:
                throw new ApiException('Invalid or missing API key. Check that your API key is present and matches your assigned key.');
                break;
            case 405:
                throw new ApiException('Invalid HTTP method. Check that the method (POST|GET) matches what the documentation indicates.');
                break;
            case 500:
                throw new ApiException('Internal server error. Try again at a later time.');
                break;
            case 412:
                throw new ApiException(
                    sprintf('Request failed: %s', $response)
                );
                break;
            case 503:
                throw new ApiException('Rate limit hit. API requests are limited to an average of 2/s. Try your request again later.');
                break;
        }
    }
}
