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
 * History Diff Model
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_History_Diff
{
    /**
     * @var FireGento_AdminMonitoring_Model_History_Data
     */
    protected $_dataModel;

    /**
     * Init the data model
     *
     * @param FireGento_AdminMonitoring_Model_History_Data $dataModel History Data Model
     */
    public function __construct(FireGento_AdminMonitoring_Model_History_Data $dataModel)
    {
        $this->_dataModel = $dataModel;
    }

    /**
     * Check if the data has changed.
     *
     * @return bool Result
     */
    public function hasChanged()
    {
        return ($this->_dataModel->getContent() != $this->_dataModel->getOrigContent());
    }

    /**
     * Generate an object diff of the original content and the actual content.
     *
     * @return array Diff Array
     */
    private function getObjectDiff()
    {
        $dataOld = $this->_dataModel->getOrigContent();
        if (is_array($dataOld)) {
            $dataNew = $this->_dataModel->getContent();
            $dataDiff = array();
            foreach ($dataOld as $key => $oldValue) {
                // compare objects serialized
                if (isset($dataNew[$key])
                    && (json_encode($oldValue) != json_encode($dataNew[$key]))
                ) {
                    $dataDiff[$key] = $oldValue;
                }
            }

            return $dataDiff;
        } else {
            return array();
        }
    }

    /**
     * Retrieve the serialized diff for the current data model.
     *
     * @return string Serialized Diff
     */
    public function getSerializedDiff()
    {
        $dataDiff = $this->getObjectDiff();

        return json_encode($dataDiff);
    }
}
