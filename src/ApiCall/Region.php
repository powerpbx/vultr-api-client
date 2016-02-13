<?php

/**
 * Vultr.com Curl Adapter
 *
 * NOTE: part of this code was extracted from
 * https://github.com/usefulz/vultr-api-client, updated for PSR compliance and
 * extended with new API calls.
 *
 * @package Vultr
 * @version 1.0
 * @author  https://github.com/malc0mn - https://github.com/usefulz
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @see     https://github.com/malc0mn/vultr-api-client
 */

namespace Vultr\ApiCall;

class Region extends AbstractApiCall
{
    /**
     * Retrieve a list of all active regions.
     *
     * Note that just because a region is listed here, does not mean that there
     * is room for new servers.
     *
     * @see https://www.vultr.com/api/#regions_region_list
     *
     * @return array
     */
    public function getList()
    {
        return $this->adapter->get('regions/list');
    }

    /**
     * Retrieve a list of the VPSPLANIDs currently available in this location.
     *
     * If your account has special plans available, you will need to pass your
     * api_key in in order to see them. For all other accounts, the API key is
     * not optional.
     *
     * @see https://www.vultr.com/api/#regions_region_available
     *
     * @param integer $datacenterId Location to check availability of
     *
     * @return array List of VPSPLANIDs
     */
    public function getAvailability($datacenterId)
    {
        $args = [
            'DCID' => (int) $datacenterId,
        ];

        return $this->adapter->get('regions/availability', $args);
    }
}
