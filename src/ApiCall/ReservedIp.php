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
     **/
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
     * @param string  $serverId Unique indentifier of the server to attach the
     * reserved IP to
     *
     * @return integer HTTP response code
     **/
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
     **/
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
     * @param string   $ipType 'v4' or 'v6' Type of reserved IP to create
     *
     * @return integer reserved IP ID
     *
     * @throws \Exception
     **/
    public function create($datacenterId, $ipType)
    {
        $allowed = ['v4', 'v6'];

        if (!in_array($ipType, $allowed)) {
            throw new \Exception(
                sprintf('IP type must be one of %s.', implode(' or ', $ipType))
            );
        }

        $args = [
            'DCID' => $datacenterId,
            'ip_type' => $ipType,
        ];

        $reservedIp = $this->adapter->post('reservedip/create', $args);

        return (int) $reservedIp['SUBID'];
    }

    /**
     * Remove a reserved IP from your account.
     *
     * You cannot get the IP address back after this.
     *
     * @see https://www.vultr.com/api/#reservedip_destroy
     *
     * @param integer $reservedIpId Unique identifier for this subscription.
     * These can be found using the getList() call.
     *
     * @return integer HTTP response code
     **/
    public function destroy($reservedIpId)
    {
        $args = ['SUBID' => $reservedIpId];

        return $this->adapter->post('reservedip/destroy', $args, true);
    }
}
