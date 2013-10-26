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
 * RowUrl Implementation for CMS pages
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_RowUrl_Model_Page
    extends FireGento_AdminMonitoring_Model_RowUrl_Model_Abstract
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return 'Mage_Cms_Model_Page';
    }

    /**
     * @return string
     */
    protected function getRoutePath()
    {
        return 'adminhtml/cms_page/edit';
    }

    /**
     * @param  Mage_Core_Model_Abstract $model
     * @return array
     */
    protected function getRouteParams(Mage_Core_Model_Abstract $model)
    {
        return array(
            'page_id' => $model->getId()
        );
    }
}
