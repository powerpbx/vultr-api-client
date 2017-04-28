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

namespace Vultr\ApiCall;

class Iso extends AbstractApiCall
{
    /**
     * List all ISOs currently available on this account.
     *
     * @see https://www.vultr.com/api/#iso_iso_list
     *
     * @return mixed Available ISO images
     */
    public function getList()
    {
        return $this->adapter->get('iso/list');
    }

    /**
     * Create a new ISO image on the current account. The ISO image will be
     * downloaded from a given URL. Download status can be checked with the
     * getList() call.
     *
     * @see https://www.vultr.com/api/#iso_create_from_url
     *
     * @param string $url Remote URL from where the ISO will be downloaded.
     *
     * @return int ISO ID
     */
    public function createFromUrl($url)
    {
        $args = [
            'url' => $url,
        ];

        $iso = $this->adapter->post('iso/create_from_url', $args);

        return (int) $iso['ISOID'];
    }
}
