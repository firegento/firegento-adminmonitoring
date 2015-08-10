<?php
/**
 * This file is part of a FireGento e.V. module.
 *
 * This FireGento e.V. module is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_AdminMonitoring
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2014 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */

/**
 * Logs the successful and failed logins to the admin backend
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Observer_Login
    extends FireGento_AdminMonitoring_Model_Observer_Log
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function logSuccess(Varien_Event_Observer $observer)
    {
        /* @var $user Mage_Admin_Model_User */
        $user = $observer->getEvent()->getUser();

        $this->_saveLoginHistory($user);
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function logFailure(Varien_Event_Observer $observer)
    {
        /* @var $user Mage_Admin_Model_User */
        $username = $observer->getEvent()->getUserName();
        /* @var $exception Exception */
        $exception = $observer->getEvent()->getException();

        /* @var $user Mage_Admin_Model_User */
        $user = Mage::getModel('admin/user')->loadByUsername($username);
        if (!$user->getId()) {
            return;
        }

        $this->_saveLoginHistory($user, true, $exception->getMessage());
    }

    /**
     * Save the login history item for the given user
     *
     * @param  Mage_Admin_Model_User $user    User
     * @param  string                $message Message
     * @throws Exception
     */
    protected function _saveLoginHistory($user, $failure = false, $message = '')
    {
        /* @var $history FireGento_AdminMonitoring_Model_History */
        $history = Mage::getModel('firegento_adminmonitoring/history');
        $history->setForcedLogging(true);
        $history->setData(array(
            'object_id'   => $user->getId(),
            'object_type' => get_class($user),
            'user_agent'  => $this->getUserAgent(),
            'ip'          => $this->getRemoteAddr(),
            'user_id'     => $user->getId(),
            'user_name'   => $user->getUsername(),
            'action'      => FireGento_AdminMonitoring_Helper_Data::ACTION_LOGIN,
            'created_at'  => now(),
        ));

        // Add some error information when login failed
        if ($failure) {
            $history->setData('status', FireGento_AdminMonitoring_Helper_Data::STATUS_FAILURE);
            $history->setData('history_message', $message);
        }

        $history->save();
    }
}
