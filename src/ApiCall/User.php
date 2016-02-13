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

class User extends AbstractApiCall
{
    /**
     * Retrieve a list of any users associated with this account.
     *
     * ACLs will contain one or more of the following flags:
     *   manage_users - Create, update, and delete other users. This will
     *                  basically grant them all other permissions
     *   subscriptions - Destroy and update any existing subscriptions (also
     *                   supporting things, such as ISOs and SSH keys)
     *   provisioning - Deploy new instances. Note this ACL requires the
     *                  subscriptions ACL
     *   billing - Manage and view billing information (invoices, payment
     *             methods)
     *   support - Create and update support tickets. Users with this flag will
     *             be CC'd on any support interactions
     *   dns - Create, update, and delete any forward DNS records (reverse is
     *         controlled by the subscriptions flag)
     *
     * @see https://www.vultr.com/api/#user_user_list
     *
     * @return array
     */
    public function getList()
    {
        return $this->adapter->get('user/list');
    }

    /**
     * Create a new user.
     *
     * @see https://www.vultr.com/api/#user_create
     *
     * @param string $email      Email address for this user
     * @param string $name       Name for this user
     * @param string $password   Password for this user
     * @param array  $acls       List of ACLs that this user should have. See
     * getList() for information on possible ACLs
     * @param string $apiEnabled (optional) 'yes' or 'no'. If yes, this user's
     * API key will work on api.vultr.com. Default is yes
     *
     * @return array
     */
    public function create($email, $name, $password, array $acls, $apiEnabled = 'yes')
    {
        $args = [
            'email'       => $email,
            'name'        => $name,
            'password'    => $password,
            'api_enabled' => ($apiEnabled == 'yes' ? 'yes' : 'no'),
            'acls'        => $acls,
        ];

        return $this->adapter->post('user/create', $args);
    }

    /**
     * Update the details for a user.
     *
     * @param string $userId     ID of the user to update
     * @param string $email      (optional) New email address for this user
     * @param string $name       (optional) New name for this user
     * @param string $password   (optional) New password for this user
     * @param array  $acls       (optional) List of ACLs that this user should
     * have. See getList() for information on possible ACLs
     * @param string $apiEnabled (optional) 'yes' or 'no'. If yes, this user's
     * API key will work on api.vultr.com.
     *
     * @return integer HTTP response code
     *
     * @throws \Exception
     **/
    public function update($userId, $email = null, $name = null, $password = null, array $acls = [], $apiEnabled = null)
    {
        if ($email === null && $name === null && $password === null && empty($acls) && $apiEnabled === null) {
            throw new \Exception('Please provide at least one parameter to update!');
        }

        $args = ['USERID' => $userId];

        if ($email !== null) {
            $args['email'] = $email;
        }

        if ($name !== null) {
            $args['name'] = $name;
        }

        if ($password !== null) {
            $args['password'] = $password;
        }

        if (!empty($acls)) {
            $args['acls'] = $acls;
        }

        if ($apiEnabled !== null) {
            $args['api_enabled'] = $apiEnabled;
        }

        return $this->adapter->post('user/update', $args);
    }

    /**
     * Delete a user.
     *
     * @see https://www.vultr.com/api/#user_delete
     *
     * @param string $userId ID of the user to delete
     *
     * @return integer HTTP respnose code
     */
    public function delete($userId)
    {
        $args = ['USERID' => $userId];

        return $this->adapter->post('user/delete', $args, true);
    }
}
