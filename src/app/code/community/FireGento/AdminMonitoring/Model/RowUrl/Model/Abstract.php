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
 * Abstract Model for RowUrl
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
abstract class FireGento_AdminMonitoring_Model_RowUrl_Model_Abstract
{
    /**
     * @return string
     */
    abstract protected function getClassName();

    /**
     * @return string
     */
    abstract protected function getRoutePath();

    /**
     * @param  Mage_Core_Model_Abstract $model
     * @return array
     */
    abstract protected function getRouteParams(Mage_Core_Model_Abstract $model);

    /**
     * sets the row url in the transport object for a cms_page model
     *
     * @param Varien_Event_Observer $observer
     */
    public function setRowUrl(Varien_Event_Observer $observer)
    {
        /**
         * @var $history FireGento_AdminMonitoring_Model_History
         */
        $history = $observer->getHistory();
        $rowUrl = $this->getRowUrl(
            $history,
            $this->getClassName(),
            $this->getRoutePath(),
            $this->getRouteParams($history->getOriginalModel())
        );
        if ($rowUrl) {
            $observer->getTransport()->setRowUrl($rowUrl);
        }
    }

    /**
     * @param  FireGento_AdminMonitoring_Model_History $history
     * @param  string                                  $className
     * @param  string                                  $routePath
     * @param  array                                   $routeParams
     * @return Mage_Adminhtml_Model_Url
     */
    protected function getRowUrl(FireGento_AdminMonitoring_Model_History $history, $className, $routePath, $routeParams)
    {
        /**
         * @var $history FireGento_AdminMonitoring_Model_History
         */
        if (!$history->isDelete()) {
            $model = $history->getOriginalModel();
            if (is_a($model, $className) AND $model->getId()) {
                return Mage::getModel('adminhtml/url')->getUrl(
                    $routePath,
                    $routeParams
                );
            }
        }

    }
}
