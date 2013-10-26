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
 * Displays the revert link in the history if applicable
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Block_Adminhtml_History_Grid_Revert
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * @param  Varien_Object $row
     * @return string
     * @throws Exception
     */
    public function render(Varien_Object $row)
    {
        if ($row instanceof FireGento_AdminMonitoring_Model_History) {
            if ($row->isUpdate() AND $row->getDecodedContentDiff()) {
                return '<a href="' . $this->getUrl('*/*/revert', array('id' => $row->getId())) . '">Revert</a>';
            }
        } else {
            throw new Exception('block is only compatible to FireGento_AdminMonitoring_Model_History');
        }
    }
}
