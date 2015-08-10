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
 * Observes Model Save
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Observer_Model_Save
    extends FireGento_AdminMonitoring_Model_Observer_Model_Abstract
{
    /**
     * @var string Object Hash
     */
    protected $_currentHash;

    /**
     * @var array
     */
    protected $_beforeIds = array();

    /**
     * Handle the model_save_after event.
     *
     * @param Varien_Event_Observer $observer Observer Instance
     */
    public function modelAfter(Varien_Event_Observer $observer)
    {
        $this->setCurrentHash($observer->getObject());
        parent::modelAfter($observer);
    }

    /**
     * Set the current hash of the given model.
     *
     * @param Mage_Core_Model_Abstract $model Object
     */
    private function setCurrentHash(Mage_Core_Model_Abstract $model)
    {
        $this->_currentHash = $this->getObjectHash($model);
    }

    /**
     * Retrieve the object hash for the given model.
     *
     * @param  object $object Object to hash
     * @return string Hashed object
     */
    private function getObjectHash($object)
    {
        return spl_object_hash($object);
    }

    /**
     * Check if data has changed.
     *
     * @return bool Result
     */
    protected function hasChanged()
    {
        return (!$this->isUpdate() || parent::hasChanged());
    }

    /**
     * Check if the current action is an update.
     *
     * @return bool
     */
    private function isUpdate()
    {
        return $this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE;
    }

    /**
     * Handle the model_save_before event.
     *
     * @param Varien_Event_Observer $observer Observer Instance
     */
    public function modelBefore(Varien_Event_Observer $observer)
    {
        /* @var $savedObject Mage_Core_Model_Abstract */
        $savedObject = $observer->getObject();
        $this->setCurrentHash($savedObject);
        $this->storeBeforeId($savedObject->getId());
    }

    /**
     * Store the before id for the current hash.
     *
     * @param int $id Object ID
     */
    private function storeBeforeId($id)
    {
        $this->_beforeIds[$this->_currentHash] = $id;
    }

    /**
     * Retrieve the current monitoring action
     *
     * @return int Action ID
     */
    protected function getAction()
    {
        if ($this->hadIdAtBefore() // for models which call model_save_before
            || $this->hasOrigData() // for models with origData but without model_save_before like stock item
        ) {
            return FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE;
        } else {
            return FireGento_AdminMonitoring_Helper_Data::ACTION_INSERT;
        }
    }

    /**
     * Check if the id was there before.
     *
     * @return bool Result
     */
    private function hadIdAtBefore()
    {
        return (isset($this->_beforeIds[$this->_currentHash]) && $this->_beforeIds[$this->_currentHash]);
    }

    /**
     * Check if the saved model has original data.
     *
     * @return bool Result
     */
    private function hasOrigData()
    {
        $data = $this->_savedModel->getOrigData();

        // unset website_ids as this is even on new entities set for catalog_product models
        unset($data['website_ids']);

        return (bool)$data;
    }
}
