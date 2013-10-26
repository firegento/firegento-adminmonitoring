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
 * History controller
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Adminhtml_HistoryController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Inits the layout, the active menu tab and the breadcrumbs
     *
     * @return FireGento_AdminMonitoring_Adminhtml_HistoryController
     */
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('firegento_adminmonitoring/history');
        $this->_addBreadcrumb(
            Mage::helper('firegento_adminmonitoring')->__('Admin Monitoring'),
            Mage::helper('firegento_adminmonitoring')->__('History')
        );

        return $this;
    }

    /**
     * Shows the history grid
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Reverts a history entry
     */
    public function revertAction()
    {
        /* @var $history FireGento_AdminMonitoring_Model_History */
        $history = Mage::getModel('firegento_adminmonitoring/history')->load($this->getRequest()->getParam('id'));

        if (!$history->getId()) {
            $model = $history->getOriginalModel();
            $model->addData($history->getDecodedContentDiff());
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__(
                    'Revert of %1$s with id %2$d successful',
                    $history->getObjectType(),
                    $history->getObjectId()
                )
            );
        }

        $this->_redirect('*/*/index');
    }
}
