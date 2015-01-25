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
 * Observes Category Move
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Observer_Category_Move
    extends FireGento_AdminMonitoring_Model_Observer_Log
{

    /**
     * Observe the category move
     *
     * @param  Varien_Event_Observer $observer Observer Instance
     * @return void
     */
    public function catalogCategoryMove(Varien_Event_Observer $observer)
    {
        $category = $observer->getCategory();

        $dataModel = Mage::getModel('firegento_adminmonitoring/history_data', $category);
        $diffModel = Mage::getModel('firegento_adminmonitoring/history_diff', $dataModel);

        $eventData = array(
            'object_id' => $dataModel->getObjectId(),
            'object_type' => $dataModel->getObjectType(),
            'content' => $dataModel->getSerializedContent(),
            'content_diff' => $diffModel->getSerializedDiff(),
            'action' => FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE,
        );

        Mage::dispatchEvent('firegento_adminmonitoring_log', $eventData);
    }
}