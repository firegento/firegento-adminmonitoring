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
 * History Model
 *
 * @method FireGento_AdminMonitoring_Model_Resource_History getResource()
 * @method FireGento_AdminMonitoring_Model_Resource_History _getResource()
 * @method int getObjectId()
 * @method string getObjectType()
 * @method string getContent()
 * @method string getContentDiff()
 * @method int getAction()
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_History extends Mage_Core_Model_Abstract
{
    /**
     * @var bool
     */
    protected $_forcedLogging = false;

    /**
     * Inits the resource model and resource collection model
     */
    protected function _construct()
    {
        $this->_init('firegento_adminmonitoring/history');
    }

    /**
     * Processing object before save data
     *
     * @return FireGento_AdminMonitoring_Model_History
     */
    protected function _beforeSave()
    {
        if (Mage::helper('firegento_adminmonitoring')->isAdminUserIdExcluded($this->getData('user_id'))
            && !$this->_forcedLogging
        ) {
            $this->_dataSaveAllowed = false;
        }

        return parent::_beforeSave();
    }

    /**
     * Set the forced logging value
     *
     * @param  bool $flag Flag
     * @return FireGento_AdminMonitoring_Model_History
     */
    public function setForcedLogging($flag)
    {
        $this->_forcedLogging = $flag;

        return $this;
    }

    /**
     * Retrieve the original model
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getOriginalModel()
    {
        $objectType = $this->getObjectType();

        /* @var Mage_Core_Model_Abstract $model */
        $model = new $objectType;
        $content = $this->getDecodedContent();
        if (isset($content['store_id'])) {
            $model->setStoreId($content['store_id']);
        }
        $model->load($this->getObjectId());

        return $model;
    }

    /**
     * Retrieve the decoded content diff
     *
     * @return array Decoded Content Diff
     */
    public function getDecodedContentDiff()
    {
        return json_decode($this->getContentDiff(), true);
    }

    /**
     * Retrieve the decoded content
     *
     * @return array Decoded Content
     */
    public function getDecodedContent()
    {
        return json_decode($this->getContent(), true);
    }

    /**
     * Check if the history action is an update action.
     *
     * @return bool Result
     */
    public function isInsert()
    {
        return ($this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_INSERT);
    }

    /**
     * Check if the history action is an update action.
     *
     * @return bool Result
     */
    public function isUpdate()
    {
        return ($this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE);
    }

    /**
     * Check if the history action is an delete action.
     *
     * @return bool
     */
    public function isDelete()
    {
        return ($this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_DELETE);
    }

    /**
     * Check if the history action is an login action
     *
     * @return bool
     */
    public function isLogin()
    {
        return ($this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_LOGIN);
    }
}
