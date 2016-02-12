<?php

namespace Vultr\ApiCall;

class Snapshot extends AbstractApiCall
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
     **/
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
     * Plans that are no longer available will not be shown. The 'windows'
     * field is no longer in use, and will always be false. Windows licenses
     * will be automatically added to any plan as necessary. If your account
     * has special plans available, you will need to pass your api_key in, in
     * order to see them. For all other accounts, the API key is not optional.
     *
     * @see https://www.vultr.com/api/#plans_plan_list
     *
     * @return mixed
     */
    public function getPlansList()
    {
        return $this->adapter->get('plans/list');
    }
}
