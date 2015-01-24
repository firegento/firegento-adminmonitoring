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
 * Abstract observer class; provides some common functions for subclasses
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
abstract class FireGento_AdminMonitoring_Model_Observer_Model_Abstract
{
    /**
     * @var Mage_Core_Model_Abstract
     */
    protected $_savedModel;

    /**
     * @var FireGento_AdminMonitoring_Model_History_Diff
     */
    protected $_diffModel;

    /**
     * @var FireGento_AdminMonitoring_Model_History_Data
     */
    protected $_dataModel;

    /**
     * Abstract method for retrieving the history action.
     *
     * @return int
     */
    abstract protected function getAction();

    /**
     * Handle the model_save_after and model_delete_after events
     *
     * @param Varien_Event_Observer $observer Observer Instance
     */
    public function modelAfter(Varien_Event_Observer $observer)
    {
        $this->storeByObserver($observer);
    }

    /**
     * Check if the data has changed.
     *
     * @return bool
     */
    protected function hasChanged()
    {
        return $this->_diffModel->hasChanged();
    }

    /**
     * Check if the data has changed and create a history entry if there are changes.
     *
     * @param Varien_Event_Observer $observer Observer Instance
     */
    protected function storeByObserver(Varien_Event_Observer $observer)
    {
        /* @var $savedModel Mage_Core_Model_Abstract */
        $savedModel = $observer->getObject();
        $this->_savedModel = $savedModel;

        if (!$this->isExcludedClass($savedModel)) {
            $this->_dataModel = Mage::getModel('firegento_adminmonitoring/history_data', $savedModel);
            $this->_diffModel = Mage::getModel('firegento_adminmonitoring/history_diff', $this->_dataModel);

            if ($this->hasChanged()) {
                $this->createHistoryForModelAction();
            }
        }
    }

    /**
     * Dispatch event for creating a history entry
     */
    private function createHistoryForModelAction()
    {
        $eventData = array(
            'object_id'    => $this->_dataModel->getObjectId(),
            'object_type'  => $this->_dataModel->getObjectType(),
            'content'      => $this->_dataModel->getSerializedContent(),
            'content_diff' => $this->_diffModel->getSerializedDiff(),
            'action'       => $this->getAction(),
        );

        Mage::dispatchEvent('firegento_adminmonitoring_log', $eventData);
    }

    /**
     * Check if the dispatched model has to be excluded from the logging.
     *
     * @return bool Result
     */
    private function isExcludedClass()
    {
        $savedModel = $this->_savedModel;

        $fullActionName = Mage::helper('firegento_adminmonitoring')->getFullActionName();

        // Check if full action name is restricted
        $globalAdminRouteExcludes = $this->getConfig()->getGlobalAdminRouteExcludes();
        if (in_array($fullActionName, $globalAdminRouteExcludes)) {
            return true;
        }

        // Fetch all object type excludes

        $objectTypeExcludes = $this->getConfig()->getObjectTypeExcludes();

        // Add all object type excludes from the partial admin route excludes
        $partialAdminRouteExcludes = $this->getConfig()->getPartialAdminRouteExcludes();
        if (isset($partialAdminRouteExcludes[$fullActionName])) {
            $objectTypeExcludes = array_merge($objectTypeExcludes, $partialAdminRouteExcludes[$fullActionName]);
        }

        $objectTypeExcludesFiltered = array_filter(
            $objectTypeExcludes,
            function ($className) use ($savedModel) {
                return is_a($savedModel, $className);
            }
        );

        return (count($objectTypeExcludesFiltered) > 0);
    }

    /**
     * @return FireGento_AdminMonitoring_Model_Config
     */
    public function getConfig()
    {
        return Mage::getSingleton('firegento_adminmonitoring/config');
    }
}
