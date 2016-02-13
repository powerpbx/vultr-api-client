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

class StartupScript extends AbstractApiCall
{
    /**
     * List all startup scripts on the current account.
     *
     * 'boot' type scripts are executed by the server's operating system on the
     * first boot. 'pxe' type scripts are executed by iPXE when the server
     * itself starts up.
     *
     * @see https://www.vultr.com/api/#startupscript_startupscript_list
     *
     * @return array
     */
    public function getList()
    {
        return $this->adapter->get('startupscript/list');
    }

    /**
     * Create a startup script.
     *
     * @see https://www.vultr.com/api/#startupscript_create
     *
     * @param string $name   Name of the newly created startup script
     * @param string $script Startup script contents
     * @param string $type   boot|pxe Type of startup script. Default is 'boot'.
     *
     * @return integer script ID
     *
     * @throws \Exception
     */
    public function create($name, $script, $type = 'boot')
    {
        $allowed = ['boot', 'pxe'];

        if (!in_array($type, $allowed)) {
            throw new \Exception(
                sprintf('Script type must be one of %s.', implode(' or ', $type))
            );
        }

        $args = [
            'name' => $name,
            'script' => $script,
            'type' => $type,
        ];

        $script = $this->adapter->post('startupscript/create', $args);

        return (int) $script['SCRIPTID'];
    }

    /**
     * Update an existing startup script.
     *
     * @param integer $scriptId SCRIPTID of script to update
     * @param string  $name     (optional) New name for the startup script
     * @param string  $script   (optional) New startup script contents
     *
     * @return integer HTTP response code
     *
     * @throws \Exception
     */
     public function update($scriptId, $name = null, $script = null)
     {
        if ($name === null && $script == null) {
            throw new \Exception(
                sprintf('Please provide name or script to update for script ID %s!', $scriptId)
            );
        }

        $args = ['SCRIPTID' => $scriptId];

        if ($name !== null) {
            $args['name'] = $name;
        }

        if ($script !== null) {
            $args['script'] = $script;
        }

         return $this->adapter->post('startupscript/update', $args, true);
     }

    /**
     * Remove a startup script.
     *
     * @see https://www.vultr.com/api/#startupscript_destroy
     *
     * @param integer $scriptId Unique identifier for this startup script. These
     * can be found using the getList() call.
     *
     * @return integer HTTP response code
     */
    public function destroy($scriptId)
    {
        $args = ['SCRIPTID' => $scriptId];

        return $this->adapter->post('startupscript/destroy', $args, true);
    }
}
