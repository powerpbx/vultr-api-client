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
 * @see     https://github.com/powerpbx/vultr-api-client
 */
namespace Vultr\ApiCall;
class Backup extends AbstractApiCall
{
    /**
     * List all backups on the current account.
     *
     * @see https://www.vultr.com/api/#backup_backup_list
     *
     * @return array
     */
    public function getList()
    {
        return $this->adapter->get('backup/list');
    }
}
