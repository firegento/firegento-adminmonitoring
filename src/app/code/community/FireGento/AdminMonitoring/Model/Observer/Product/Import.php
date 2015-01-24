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
 * Observes the product import
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Observer_Product_Import
    extends FireGento_AdminMonitoring_Model_Observer_Log
{
    const XML_PATH_ADMINMONITORING_LOG_PRODUCT_IMPORT = 'admin/firegento_adminmonitoring/product_import_logging';

    /**
     * Observe the product import before
     *
     * @param  Varien_Event_Observer $observer Observer Instance
     * @return void
     */
    public function catalogProductImportFinishBefore(Varien_Event_Observer $observer)
    {
        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINMONITORING_LOG_PRODUCT_IMPORT)) {
            return;
        }

        $productIds = $observer->getEvent()->getAdapter()->getAffectedEntityIds();

        $objectType = get_class(Mage::getModel('catalog/product'));
        $content = json_encode(array('updated_during_import' => ''));
        $userAgent = $this->getUserAgent();
        $ip = $this->getRemoteAddr();
        $userId = $this->getUserId();
        $userName = $this->getUserName();

        foreach ($productIds as $productId) {
            /* @var FireGento_AdminMonitoring_Model_History $history */
            $history = Mage::getModel('firegento_adminmonitoring/history');
            $history->setData(array(
                'object_id'    => $productId,
                'object_type'  => $objectType,
                'content'      => $content,
                'content_diff' => '{}',
                'user_agent'   => $userAgent,
                'ip'           => $ip,
                'user_id'      => $userId,
                'user_name'    => $userName,
                'action'       => FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE,
                'created_at'   => now(),
            ));
            $history->save();
            $history->clearInstance();
        }
    }
}
