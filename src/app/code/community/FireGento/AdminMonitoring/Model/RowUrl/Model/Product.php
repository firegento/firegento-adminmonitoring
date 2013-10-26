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
 * RowUrl Implementation for Products
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_RowUrl_Model_Product
    extends FireGento_AdminMonitoring_Model_RowUrl_Model_Abstract
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return 'Mage_Catalog_Model_Product';
    }

    /**
     * @return string
     */
    protected function getRoutePath()
    {
        return 'adminhtml/catalog_product/edit';
    }

    /**
     * @param  Mage_Core_Model_Abstract $model
     * @return array
     */
    protected function getRouteParams(Mage_Core_Model_Abstract $model)
    {
        return array(
            'id'    => $model->getId(),
            'store' => $model->getStoreId(),
        );
    }
}
