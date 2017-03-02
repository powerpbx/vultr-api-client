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

use Vultr\Exception\ApiException;

class MetaData extends AbstractApiCall
{
    /**
     * Retrieve information about the current account
     *
     * @see https://www.vultr.com/api/#account_info
     *
     * @return array
     */
    public function getAccountInfo()
    {
        return $this->adapter->get('account/info');
    }

    /**
     * Retrieve a list of available applications.
     *
     * These refer to applications that can be launched when creating a Vultr
     * VPS.
     *
     * @see https://www.vultr.com/api/#app_app_list
     *
     * @return mixed
     */
    public function getAppList()
    {
        return $this->adapter->get('app/list');
    }

    /**
     * Retrieve information about the current API key
     *
     * @see https://www.vultr.com/api/#auth_info
     *
     * @return mixed
     */
    public function getAuthInfo()
    {
       return $this->adapter->get('auth/info');
    }

    /**
     * List all backups on the current account.
     *
     * @see https://www.vultr.com/api/#backup_backup_list
     *
     * @return mixed
     */
    public function getBackupList()
    {
       return $this->adapter->get('backup/list');
    }

    /**
     * List all ISOs currently available on this account.
     *
     * @see https://www.vultr.com/api/#iso_iso_list
     *
     * @return mixed Available ISO images
     */
    public function getIsoList()
    {
        return $this->adapter->get('iso/list');
    }

    /**
     * Retrieve a list of available operating systems.
     * If the 'windows' flag is true, a Windows license will be included with
     * the instance, which will increase the cost.
     *
     * @see https://www.vultr.com/api/#os_os_list
     *
     * @return array
     */
    public function getOsList()
    {
       return $this->adapter->get('os/list');
    }

    /**
     * Retrieve a list of all active plans.
     *
     * Plans that are no longer available will not be shown.
     *
     * The 'windows' field is no longer in use, and will always be false.
     * Windows licenses will be automatically added to any plan as necessary.
     *
     * The "deprecated" field indicates that the plan will be going away in the
     * future. New deployments of it will still be accepted, but you should
     * begin to transition away from it's usage. Typically, deprecated plans are
     * available for 30 days after they are deprecated.
     *
     * The sandbox ($2.50) plan is not available in the API.
     *
     * @see https://www.vultr.com/api/#plans_plan_list
     *
     * @param string $type The type of plans to return. Possible values: "all",
     * "vc2", "ssd", "vdc2", "dedicated".
     *
     * @return mixed
     */
    public function getPlansList($type = 'all')
    {
        $allowed = ['all', 'vc2', 'ssd', 'vdc2', 'dedicated'];

        if (!in_array($type, $allowed)) {
            throw new ApiException(
                sprintf('Type must be one of %s.', implode(' or ', $allowed))
            );
        }

        $args = ['type' => $type];

        return $this->adapter->get('plans/list', $args);
    }

    /**
     * Retrieve a list of all active vc2 plans.
     *
     * Plans that are no longer available will not be shown.
     *
     * The "deprecated" field indicates that the plan will be going away in the
     * future. New deployments of it will still be accepted, but you should
     * begin to transition away from it's usage. Typically, deprecated plans are
     * available for 30 days after they are deprecated.
     *
     * The sandbox ($2.50) plan is not available in the API.
     *
     * @see https://www.vultr.com/api/#plans_plan_list_vc2
     *
     * @return mixed
     */
    public function getPlansListVc2()
    {
        return $this->adapter->get('plans/list_vc2');
    }

    /**
     * Retrieve a list of all active vdc2 plans.
     *
     * Plans that are no longer available will not be shown.
     *
     * The "deprecated" field indicates that the plan will be going away in the
     * future. New deployments of it will still be accepted, but you should
     * begin to transition away from it's usage. Typically, deprecated plans are
     * available for 30 days after they are deprecated.
     *
     * @see https://www.vultr.com/api/#plans_plan_list_vdc2
     *
     * @return mixed
     */
    public function getPlansListVdc2()
    {
        return $this->adapter->get('plans/list_vdc2');
    }
}
