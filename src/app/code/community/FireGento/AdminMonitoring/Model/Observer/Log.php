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
 * Logging model
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Observer_Log
{
    /**
     * Log the data for the given observer model.
     *
     * @param Varien_Event_Observer $observer Observer Instance
     */
    public function log(Varien_Event_Observer $observer)
    {
        /* @var $history FireGento_AdminMonitoring_Model_History */
        $history = Mage::getModel('firegento_adminmonitoring/history');
        $history->setData(array(
            'object_id'    => $observer->getObjectId(),
            'object_type'  => $observer->getObjectType(),
            'content'      => $observer->getContent(),
            'content_diff' => $observer->getContentDiff(),
            'user_agent'   => $this->getUserAgent(),
            'ip'           => $this->getRemoteAddr(),
            'user_id'      => $this->getUserId(),
            'user_name'    => $this->getUserName(),
            'action'       => $observer->getAction(),
            'created_at'   => now(),
        ));

        $history->save();
    }

    /**
     * Retrieve the current admin user id
     *
     * @return int User ID
     */
    public function getUserId()
    {
        if ($this->getUser()) {
            $userId = $this->getUser()->getUserId();
        } else {
            $userId = 0;
        }

        return $userId;
    }

    /**
     * Retrieve the current admin user name
     *
     * @return string User Name
     */
    public function getUserName()
    {
        if ($this->getUser()) {
            $userName = $this->getUser()->getUsername();
        } else {
            $userName = '';
        }

        return $userName;
    }

    /**
     * Retrieve the current admin user
     *
     * @return Mage_Admin_Model_User
     */
    public function getUser()
    {
        /* @var $session Mage_Admin_Model_Session */
        $session = Mage::getSingleton('admin/session');

        return $session->getUser();
    }

    /**
     * Retrieve the user agent of the current user.
     *
     * @return string User Agent
     */
    public function getUserAgent()
    {
        return (isset($_SERVER['HTTP_USER_AGENT']) ? (string)$_SERVER['HTTP_USER_AGENT'] : '');
    }

    /**
     * Retrieve the remote address of the current user.
     *
     * @return string IPv4|long
     */
    public function getRemoteAddr()
    {
        return Mage::helper('core/http')->getRemoteAddr();
    }
}
