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
 * Displays the logging history detail page
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Block_Adminhtml_History_View
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Constructor of the grid container
     */
    public function __construct()
    {
        /* @var $history FireGento_AdminMonitoring_Model_History */
        $history = Mage::registry('current_history');

        $this->_blockGroup = 'firegento_adminmonitoring';
        $this->_controller = 'adminhtml_history_view';
        $this->_headerText = Mage::helper('firegento_adminmonitoring')->__('History Entry #%s', $history->getId());
        parent::__construct();
        $this->removeButton('add');

        // Add back to history button
        $this->_addBackButton();

        // Add revert button is possible
        if ($history->isUpdate() && $history->getDecodedContentDiff()) {
            $this->addButton('revert', array(
                'label'   => Mage::helper('firegento_adminmonitoring')->__('Revert Changes'),
                'onclick' => 'confirmSetLocation(\'' . Mage::helper('firegento_adminmonitoring')->__('Are you sure?') . '\', \'' . $this->getUrl('*/*/revert', array('id' => $history->getId())) . '\')',
                'class'   => 'delete',
            ), 10);
        }
    }

    /**
     * Call not the direct parent but the parent-parent class because we don't want to add
     * an actual grid block here.
     *
     * @return FireGento_AdminMonitoring_Block_Adminhtml_History_View
     */
    protected function _prepareLayout()
    {
        return call_user_func(array(get_parent_class(get_parent_class($this)), '_prepareLayout'));
    }

    /**
     * Retrieve the back url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*');
    }
}
