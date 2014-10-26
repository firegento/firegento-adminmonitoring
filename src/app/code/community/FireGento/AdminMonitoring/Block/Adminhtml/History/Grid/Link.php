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
 * Displays the link to the object in the history if applicable
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Block_Adminhtml_History_Grid_Link
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders the given column
     *
     * @param  Varien_Object $row Column Object
     * @throws Exception
     * @return string Rendered column
     */
    public function render(Varien_Object $row)
    {
        if ($row instanceof FireGento_AdminMonitoring_Model_History) {
            /* @var $helper FireGento_AdminMonitoring_Helper_Data */
            $helper = Mage::helper('firegento_adminmonitoring');

            $link = $helper->getRowUrl($row);
            if ($link) {
                return sprintf('<a href="%s">%s</a>', $link, $helper->__('Go To Object'));
            } else {
                return '-';
            }
        } else {
            throw new Exception('Block is only compatible to FireGento_AdminMonitoring_Model_History');
        }
    }
}
