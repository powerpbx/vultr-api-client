<?php

namespace Vultr\ApiCall;

class Dns extends AbstractApiCall
{
    /**
     * List all domains associated with the current account.
     *
     * @see https://www.vultr.com/api/#dns_dns_list
     *
     * @return array
     **/
    public function getList()
    {
        return $this->adapter->get('dns/list');
    }

    /**
     * List all the records associated with a particular domain.
     *
     * @see https://www.vultr.com/api/#dns_records
     *
     * @param string $domain Domain to list records for
     *
     * @return array
     **/
    public function getRecords($domain)
    {
        $args = ['domain' => $domain];

        return $this->adapter->get('dns/records', $args);
    }

    /**
     * Create a domain name in DNS.
     *
     * @see https://www.vultr.com/api/#dns_create_domain
     *
     * @param string $domain   Domain name to create
     * @param string $serverIp Server IP to use when creating default records
     * (A and MX)
     *
     * @return integer HTTP response code
     **/
    public function createDomain($domain, $serverIp)
    {
        $args = [
            'domain' => $domain,
            'serverip' => $serverIp,
        ];

        return $this->adapter->post('dns/create_domain', $args, true);
    }

    /**
     * Delete a domain name (and all associated records).
     *
     * @see https://www.vultr.com/api/#dns_delete_domain
     *
     * @param string $domain Domain name to delete
     *
     * @return integer HTTP response code
     **/
    public function deleteDomain($domain)
    {
        $args = ['domain' => $domain];

        return $this->adapter->post('dns/delete_domain', $args, true);
    }

    /**
     * Add a DNS record.
     *
     * @see https://www.vultr.com/api/#dns_create_record
     *
     * @param string $domain Domain name to add record to
     * @param string $name   string Name (subdomain) of record
     * @param string $type   Type (A, AAAA, MX, etc) of record
     * @param string $data   Data for this record
     * @param integer $ttl   (optional) TTL of this record
     * @param integer $priority (only required for MX and SRV) Priority of this
     * record (omit the priority from the data)
     *
     * @return integer HTTP response code
     **/
    public function createRecord($domain, $name, $type, $data, $ttl = null, $priority = null)
    {
        $args = [
            'domain' => $domain,
            'name' => $name,
            'type' => $type,
            'data' => $data,
        ];

        if ($ttl !== null) {
            $args['ttl'] = $ttl;
        }

        if ($priority !== null) {
            $args['priority'] = $priority;
        }

        return $this->adapter->post('dns/create_record', $args, true);
    }

    /**
     * Update a DNS record
     *
     * @see https://www.vultr.com/api/#dns_create_record
     *
     * @param string  $recordId Domain name to add record to
     * @param string  $domain   Domain name to add record to
     * @param string  $name     Name (subdomain) of record
     * @param string  $data     Data for this record
     * @param integer $ttl      (optional) TTL of this record
     * @param integer $priority (only required for MX and SRV) Priority of this
     * record (omit the priority from the data)
     *
     * @return integer HTTP response code
     **/
    public function updateRecord($recordId, $domain, $name, $data, $ttl = null, $priority = null)
    {
        $args = [
            'RECORDID' => $recordId,
            'domain' => $domain,
            'name' => $name,
            'data' => $data,
        ];

        if ($ttl !== null) {
            $args['ttl'] = $ttl;
        }

        if ($priority !== null) {
            $args['priority'] = $priority;
        }

        return $this->adapter->post('dns/update_record', $args, true);
    }

    /**
     * Delete an individual DNS record
     *
     * @see https://www.vultr.com/api/#dns_delete_record
     *
     * @param string $domain Domain name to delete record from
     * @param string $recordId ID of record to delete (see getRecords())
     *
     * @return integer HTTP response code
     **/
    public function deleteRecord($domain, $recordId)
    {
        $args = [
            'domain' => $domain,
            'RECORDID' => $recordId,
        ];

        return $this->adapter->post('dns/delete_record', $args, true);
    }
}
