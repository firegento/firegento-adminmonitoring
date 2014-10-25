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
 * Source model for history status
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_System_Config_Source_History_Status
{
    /**
     * @var null
     */
    protected $_options = null;

    /**
     * Retrieve the option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (null === $this->_options) {
            $this->_options = array(
                array(
                    'value' => FireGento_AdminMonitoring_Helper_Data::STATUS_SUCCESS,
                    'label' => Mage::helper('firegento_adminmonitoring')->__('Success'),
                ),
                array(
                    'value' => FireGento_AdminMonitoring_Helper_Data::STATUS_FAILURE,
                    'label' => Mage::helper('firegento_adminmonitoring')->__('Failure'),
                )
            );
        }

        return $this->_options;
    }

    /**
     * Retrieve the option hash
     *
     * @return array
     */
    public function toOptionHash()
    {
        $options = $this->toOptionArray();
        $optionHash = array();

        foreach ($options as $option) {
            $optionHash[$option['value']] = $option['label'];
        }

        return $optionHash;
    }
}
