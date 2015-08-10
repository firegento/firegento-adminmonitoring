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
 * History Data Model
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_History_Data
{
    /**
     * @var Mage_Core_Model_Abstract
     */
    protected $_savedModel;

    /**
     * Init the saved model
     *
     * @param Mage_Core_Model_Abstract $savedModel Model which is to be saved
     */
    public function __construct(Mage_Core_Model_Abstract $savedModel)
    {
        $this->_savedModel = $savedModel;
    }

    /**
     * Retrieve the serialized content
     *
     * @return string Serialized Content
     */
    public function getSerializedContent()
    {
        return json_encode($this->getContent());
    }

    /**
     * Retrieve the content of the saved model
     *
     * @return array Content
     */
    public function getContent()
    {
        // have to re-load the model as based on database datatypes the format of values changes
        $className = get_class($this->_savedModel);
        $model = new $className;

        // Add store id if given
        if ($storeId = $this->_savedModel->getStoreId()) {
            $model->setStoreId($storeId);
        }
        $model->load($this->_savedModel->getId());

        return $this->_filterObligatoryFields($model->getData());
    }

    /**
     * Remove the obligatory fields from the data
     *
     * @param  array $data Data
     * @return array Filtered Data
     */
    protected function _filterObligatoryFields($data)
    {
        $fields = Mage::getSingleton('firegento_adminmonitoring/config')->getFieldExcludes();
        foreach ($fields as $field) {
            unset($data[$field]);
        }

        return $data;
    }

    /**
     * Retrieve the original content of the saved model
     *
     * @return array Data
     */
    public function getOrigContent()
    {
        $data = $this->_savedModel->getOrigData();

        return $this->_filterObligatoryFields($data);
    }

    /**
     * Retrieve the object type of the saved model
     *
     * @return string Object Type
     */
    public function getObjectType()
    {
        return get_class($this->_savedModel);
    }

    /**
     * Retrieve the object id of the saved model
     *
     * @return int Object ID
     */
    public function getObjectId()
    {
        return $this->_savedModel->getId();
    }
}
