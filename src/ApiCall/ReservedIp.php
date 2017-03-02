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

use Vultr\Exception\ApiException;

class ReservedIp extends AbstractApiCall
{
    /**
     * List all the active reserved IPs on this account.
     *
     * subnet_size is the size of the network assigned to this subscription.
     * This will typically be a /64 for IPv6, or a /32 for IPv4.
     *
     * @see https://www.vultr.com/api/#reservedip_ip_list
     *
     * @return array
     */
    public function getList()
    {
        return $this->adapter->get('reservedip/list');
    }

    /**
     * Attach a reserved IP to an existing subscription.
     *
     * @see https://www.vultr.com/api/#reservedip_attach
     *
     * @param string  $ip       Reserved IP to attach to your account (use the
     * full subnet here)
     * @param string  $serverId Unique identifier of the server to attach the
     * reserved IP to
     *
     * @return integer HTTP response code
     */
    public function attach($ip, $serverId)
    {
        $args = [
            'ip_address' => $ip,
            'attach_SUBID' => $serverId,
        ];

        return $this->adapter->post('reservedip/attach', $args, true);
    }

    /**
     * Detach a reserved IP from an existing subscription.
     *
     * @see https://www.vultr.com/api/#reservedip_detach
     *
     * @param string  $ip       Reserved IP to detach from your account (use the
     * full subnet here)
     * @param string  $serverId Unique identifier of the server to detach the
     * reserved IP from
     *
     * @return integer HTTP response code
     */
    public function detach($ip, $serverId)
    {
        $args = [
            'ip_address' => $ip,
            'detach_SUBID' => $serverId,
        ];

        return $this->adapter->post('reservedip/detach', $args, true);
    }

    /**
     * Create a new reserved IP.
     *
     * Reserved IPs can only be used within the same datacenter that they are
     * created in.
     *
     * @see https://www.vultr.com/api/#reservedip_create
     *
     * @param integer  $datacenterId Location to create this reserved IP in.
     * See v1/regions/list
     * @param string   $ipType       'v4' or 'v6' Type of reserved IP to create
     * @param string   $label        (optional) Label for this reserved IP
     *
     * @return integer reserved IP ID
     *
     * @throws ApiException
     */
    public function create($datacenterId, $ipType, $label = null)
    {
        $allowed = ['v4', 'v6'];

        if (!in_array($ipType, $allowed)) {
            throw new ApiException(
                sprintf('IP type must be one of %s.', implode(' or ', $allowed))
            );
        }

        $args = [
            'DCID' => $datacenterId,
            'ip_type' => $ipType,
        ];

        if ($label !== null) {
            $args['label'] = $label;
        }

        $reservedIp = $this->adapter->post('reservedip/create', $args);

        return (int) $reservedIp['SUBID'];
    }

    /**
     * Remove a reserved IP from your account.
     *
     * After making this call, you will not be able to recover the IP address.
     *
     * @see https://www.vultr.com/api/#reservedip_destroy
     *
     * @param integer $reservedIpId Unique identifier for this reserved IP.
     * These can be found using the getList() call.
     *
     * @return integer HTTP response code
     */
    public function destroy($reservedIpId)
    {
        $args = ['SUBID' => $reservedIpId];

        return $this->adapter->post('reservedip/destroy', $args, true);
    }

    /**
     * Convert an existing IP on a subscription to a reserved IP.
     *
     * Returns the SUBID of the newly created reserved IP.
     *
     * @see https://www.vultr.com/api/#reservedip_convert
     *
     * @param integer $serverId SUBID of the server that currently has the IP
     * address you want to convert
     * @param string  $ip       IP address you want to convert (v4 must be a
     * /32, v6 must be a /64)
     * @param string $label     (optional) Label for this reserved IP
     *
     * @return integer reserved IP ID
     */
    public function convert($serverId, $ip, $label = null)
    {
        $args = [
            'SUBID' => $serverId,
            'ip_address' => $ip,
        ];

        if ($label !== null) {
            $args['label'] = $label;
        }

        $reservedIp = $this->adapter->post('reservedip/convert', $args);

        return (int) $reservedIp['SUBID'];
    }
}
