<?php

/**
 * Vultr.com PHP API Client
 *
 * Dummy API endpoint to allow actual adapter tests but with dummy data.
 *
 * @package Vultr
 * @version 1.0
 * @author  https://github.com/malc0mn - https://github.com/usefulz
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see     https://github.com/malc0mn/vultr-api-client
 */

require_once 'JsonData.php';

// Our fake 'content store'.
$jsonData = new \Vultr\Tests\JsonData();

// Grab requested url.
$url = ltrim($_SERVER['PATH_INFO'], '/');

// Prepare arguments.
$args = $_GET;
unset($args['api_key']);

// Return fake data.
header('Content-Type: application/json');
print(
    $jsonData->getResponse($url, $args)
);
