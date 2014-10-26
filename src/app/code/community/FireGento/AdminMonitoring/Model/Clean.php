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
 * Cleans the history after a configurable amount of time.
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Clean
{
    const XML_PATH_ADMINMONITORING_INTERVAL = 'admin/firegento_adminmonitoring/interval';
    const XML_PATH_ADMINMONITORING_CLEAN_ENABLED = 'admin/firegento_adminmonitoring/enable_cleaning';

    /**
     * Cronjob method for cleaning the database table.
     *
     * @return FireGento_AdminMonitoring_Model_Clean
     */
    public function scheduledCleanAdminMonitoring()
    {
        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINMONITORING_CLEAN_ENABLED)) {
            return $this;
        }

        try {
            $this->clean();
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }

    /**
     * Clean the database table for the given interval.
     *
     * @return FireGento_AdminMonitoring_Model_Clean
     */
    public function clean()
    {
        if (!Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_CLEAN_ENABLED)
            || !Mage::getStoreConfigFlag(self::XML_PATH_ADMINMONITORING_INTERVAL)
        ) {
            return $this;
        }

        $interval = Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_INTERVAL);

        /* @var $adminMonitoringCollection FireGento_AdminMonitoring_Model_Resource_History_Collection */
        $adminMonitoringCollection = Mage::getModel('firegento_adminmonitoring/history')
            ->getCollection()
            ->addFieldToFilter(
                'created_at',
                array(
                    'lt' => new Zend_Db_Expr("DATE_SUB('" . now() . "', INTERVAL " . (int) $interval . " DAY)")
                )
            );

        foreach ($adminMonitoringCollection as $history) {
            $history->delete();
        }

        return $this;
    }
}
