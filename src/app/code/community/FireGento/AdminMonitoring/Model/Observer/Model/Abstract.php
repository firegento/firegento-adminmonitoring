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
 * @copyright 2013 FireGento Team (http://www.firegento.com)
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
    protected $savedModel;

    /**
     * @var FireGento_AdminMonitoring_Model_History_Diff
     */
    private $diffModel;

    /**
     * @var FireGento_AdminMonitoring_Model_History_Data
     */
    private $dataModel;

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
        return $this->diffModel->hasChanged();
    }

    /**
     * Check if the data has changed and create a history entry if there are changes.
     *
     * @param Varien_Event_Observer $observer Observer Instance
     */
    protected function storeByObserver(Varien_Event_Observer $observer)
    {
        /**
         * @var $savedModel Mage_Core_Model_Abstract
         */
        $savedModel = $observer->getObject();
        $this->savedModel = $savedModel;

        if (!$this->isExcludedClass($savedModel)) {
            $this->dataModel = Mage::getModel('firegento_adminmonitoring/history_data', $savedModel);
            $this->diffModel = Mage::getModel('firegento_adminmonitoring/history_diff', $this->dataModel);

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
        Mage::dispatchEvent(
            'firegento_adminmonitoring_log',
            array(
                 'object_id' => $this->dataModel->getObjectId(),
                 'object_type' => $this->dataModel->getObjectType(),
                 'content' => $this->dataModel->getSerializedContent(),
                 'content_diff' => $this->diffModel->getSerializedDiff(),
                 'action' => $this->getAction(),
            )
        );
    }

    /**
     * Check if the dispatched model has to be excluded from the logging.
     *
     * @return bool Result
     */
    private function isExcludedClass()
    {
        $savedModel = $this->savedModel;

        $objectTypeExcludes = array_keys(Mage::getStoreConfig('firegento_adminmonitoring_config/exclude/object_types'));
        $objectTypeExcludesFiltered = array_filter(
            $objectTypeExcludes,
            function ($className) use ($savedModel) {
                return is_a($savedModel, $className);
            }
        );

        return (count($objectTypeExcludesFiltered) > 0);
    }
}
