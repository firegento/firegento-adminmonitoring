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
 * Observer Model
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Model_Observer
{
    const XML_PATH_ADMINMONITORING_CLEAN_ENABLED = 'admin/firegento_adminmonitoring/enable_cleaning';

    /**
     * Cleaning Database Entries
     *
     * @param Mage_Cron_Model_Schedule $schedule
     * @return $this
     */
    public function scheduledCleanAdminMonitoring(Mage_Cron_Model_Schedule $schedule)
    {
        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINMONITORING_CLEAN_ENABLED)) {
            return $this;
        }

        try {
            Mage::getModel('firegento_adminmonitoring/clean')->clean();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
