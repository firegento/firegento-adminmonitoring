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
 * Abstract source model
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
abstract class FireGento_AdminMonitoring_Model_System_Config_Source_SourceAbstract
{
    /**
     * @var array
     */
    protected $_options = null;

    /**
     * Retrieve the option array
     *
     * @param  bool $withEmpty Flag if empty value should be added
     * @return array
     */
    abstract public function toOptionArray($withEmpty = true);

    /**
     * Retrieve the option hash
     *
     * @param  bool $withEmpty Flag if empty value should be added
     * @return array
     */
    public function toOptionHash($withEmpty = true)
    {
        $options = $this->toOptionArray($withEmpty);
        $optionHash = array();

        foreach ($options as $option) {
            $optionHash[$option['value']] = $option['label'];
        }

        return $optionHash;
    }

    /**
     * Retrieve the helper instance
     *
     * @return FireGento_AdminMonitoring_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('firegento_adminmonitoring');
    }
}
