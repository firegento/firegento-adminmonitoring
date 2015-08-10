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
    const XML_PATH_ADMINMONITORING_INTERVAL      = 'admin/firegento_adminmonitoring/interval';
    const XML_PATH_ADMINMONITORING_CLEAN_ENABLED = 'admin/firegento_adminmonitoring/enable_cleaning';

    /**
     * Clean in chunks.
     *
     * CHUNK_SIZE determines the items cleared per chunk.
     *
     * CHUNK_RUNS determines the number of chunks cleaned per call to clean()
     *
     * I.e. per call of clean(), at most CHUNK_SIZE * CHUNK_RUNS items are cleaned.
     */
    const CHUNK_SIZE = 1000;
    const CHUNK_RUNS = 250;

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

        $this->cleanInChunks();

        return $this;
    }

    /**
     * Clean the database table for the given interval, usink chunks to avoid memory over-usage.
     *
     * @return $this
     */
    protected function cleanInChunks()
    {
        $numChunks = 0;
        do {
            $cleanedItems = $this->cleanChunk();
        } while ($cleanedItems == static::CHUNK_SIZE && $numChunks++ < static::CHUNK_RUNS);

        return $this;
    }

    /**
     * Clean a chunk of the items in database table for the given interval.
     *
     * @return int Number of items deleted
     */
    protected function cleanChunk()
    {
        $interval = Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_INTERVAL);

        /* @var $adminMonitoringCollection FireGento_AdminMonitoring_Model_Resource_History_Collection */
        $adminMonitoringCollection = Mage::getModel('firegento_adminmonitoring/history')
            ->getCollection()
            ->setPageSize(static::CHUNK_SIZE)
            ->addFieldToFilter(
                'created_at',
                array(
                    'lt' => new Zend_Db_Expr("DATE_SUB('" . now() . "', INTERVAL " . (int)$interval . " DAY)")
                )
            );

        $count = 0;

        foreach ($adminMonitoringCollection as $history) {
            $history->delete();
            $count++;
        }

        return $count;
    }
}
