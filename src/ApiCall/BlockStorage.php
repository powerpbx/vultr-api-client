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

class BlockStorage extends AbstractApiCall
{
    /**
     * Retrieve a list of any active block storage subscriptions on this
     * account.
     *
     * @param integer $blockStorageId (optional) Unique identifier of a
     * subscription. Only the subscription object will be returned.
     *
     * @see https://www.vultr.com/api/#block_block_list
     *
     * @return array
     */
    public function getList($blockStorageId = null)
    {
        $args = [];

        if ($blockStorageId !== null) {
            $args['SUBID'] = (int) $blockStorageId;
        }

        return $this->adapter->get('block/list', $args);
    }

    /**
     * Attach a block storage subscription to a VPS subscription.
     *
     * The block storage volume must not be attached to any other VPS
     * subscriptions for this to work.
     *
     * @see https://www.vultr.com/api/#block_attach
     *
     * @param integer $blockStorageId ID of the block storage subscription to
     * attach
     * @param integer $serverId       ID of the VPS subscription to mount the
     * block storage subscription to
     *
     * @return integer HTTP response code
     */
    public function attach($blockStorageId, $serverId)
    {
        $args = [
            'SUBID' => $blockStorageId,
            'attach_to_SUBID' => $serverId,
        ];

        return $this->adapter->post('block/attach', $args, true);
    }

    /**
     * Create a block storage subscription.
     *
     * @see https://www.vultr.com/api/#block_create
     *
     * @param integer $datacenterId DCID of the location to create this
     * subscription in. See region()->getList()
     * @param integer $sizeGb       Size (in GB) of this subscription.
     * @param string  $label        (optional) Text label that will be
     * associated with the subscription
     *
     * @return array
     */
    public function create($datacenterId, $sizeGb, $label = null)
    {
        $args = [
            'DCID' => (int) $datacenterId,
            'size_gb' => (int) $sizeGb,
        ];

        if ($label !== null) {
            $args['label'] = $label;
        }

        return $this->adapter->post('block/create', $args);
    }

    /**
     * Delete a block storage subscription.
     *
     * All data will be permanently lost.
     * There is no going back from this call.
     *
     * @see https://www.vultr.com/api/#block_delete
     *
     * @param string $groupId Firewall group to delete.
     *
     * @return integer HTTP response code
     */
    public function delete($blockStorageId)
    {
        $args = ['SUBID' => $blockStorageId];

        return $this->adapter->post('block/delete', $args, true);
    }

    /**
     * Detach a block storage subscription from the currently attached instance.
     *
     * @see https://www.vultr.com/api/#block_detach
     *
     * @param integer $blockStorageId ID of the block storage subscription to
     * detach
     *
     * @return integer HTTP response code
     */
    public function detach($blockStorageId)
    {
        $args = ['SUBID' => $blockStorageId];

        return $this->adapter->post('block/detach', $args, true);
    }

    /**
     * Set the label of a block storage subscription.
     *
     * @see https://www.vultr.com/api/#block_label_set
     *
     * @param string  $blockStorageId ID of the block storage subscription.
     * @param string  $label          Text label that will be shown in the
     * control panel.
     *
     * @return integer HTTP response code
     */
    public function setLabel($blockStorageId, $label)
    {
        $args = [
            'SUBID' => $blockStorageId,
            'label' => $label,
        ];

        return $this->adapter->post('block/label_set', $args, true);
    }

    /**
     * Resize the block storage volume to a new size.
     *
     * WARNING: When shrinking the volume, you must manually shrink the
     * filesystem and partitions beforehand, or you will lose data.
     *
     * @see https://www.vultr.com/api/#block_resize
     *
     * @param integer $blockStorageId ID of the block storage subscription to
     * resize
     * @param integer $sizeGb         New size (in GB) of the block storage
     * subscription
     *
     * @return integer HTTP response code
     */
    public function resize($blockStorageId, $sizeGb)
    {
        $args = [
            'SUBID' => (int) $blockStorageId,
            'size_gb' => (int) $sizeGb,
        ];

        return $this->adapter->post('block/resize', $args, true);
    }
}
