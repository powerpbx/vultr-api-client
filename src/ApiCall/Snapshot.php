<?php

namespace Vultr\ApiCall;

class Snapshot extends AbstractApiCall
{
    /**
     * List all snapshots on the current account.
     *
     * @see https://www.vultr.com/api/#snapshot_snapshot_list
     *
     * @return array
     */
    public function getList()
    {
        return $this->adapter->get('snapshot/list');
    }

    /**
     * Create a snapshot from an existing virtual machine.
     *
     * The virtual machine does not need to be stopped.
     *
     * @see https://www.vultr.com/api/#snapshot_create
     *
     * @param integer $serverId Identifier of the virtual machine to create a
     * snapshot from
     * @param string $description (optional) Description of snapshot contents
     *
     * @return string snapshot ID
     */
    public function create($serverId, $description = null)
    {
        $args = ['SUBID' => (int) $serverId];

        if ($description !== null) {
            $args['description'] = $description;
        }

        $snapshot = $this->adapter->post('snapshot/create', $args);

        return $snapshot['SNAPSHOTID'];
    }

    /**
     * Destroy (delete) a snapshot.
     *
     * There is no going back from this call.
     *
     * @see https://www.vultr.com/api/#snapshot_destroy
     *
     * @param string $snapshotId Unique identifier for this snapshot.
     *
     * @return integer HTTP response code
     */
    public function destroy($snapshotId)
    {
        $args = ['SNAPSHOTID' => $snapshotId];

        return $this->adapter->post('snapshot/destroy', $args, true);
    }
}
